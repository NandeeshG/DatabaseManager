<?php
//slim
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';
error_reporting(E_ALL);
$app = AppFactory::create();

//only for dev env
//ini_set('display_errors', 1);
//ini_set('log_errors',1);

//connect
$dbconn = pg_connect("host=localhost dbname=school user=nandeesh password=789&*(") or die('Could not connect: '.pg_last_error());

function my_query($query, &$errstr)
{
    if (!pg_connection_busy($GLOBALS['dbconn'])) {
        pg_send_query($GLOBALS['dbconn'], $query);
    }
    $result = pg_get_result($GLOBALS['dbconn']);
    $res_stat = pg_result_status($result);
    $errstr = $errstr.pg_result_error_field($result, PGSQL_DIAG_MESSAGE_PRIMARY)."\n";
    if ($res_stat==0 || $res_stat==5 || $res_stat==6 ||$res_stat==7) {
        return false;
    } else {
        return $result;
    }
}

function response_error(&$response, $usermsg, $devmsg)
{
    $errarr = ["user_msg"=>$usermsg, "dev_msg"=>$devmsg];
    $response->getBody()->write(json_encode($errarr));
    return $response->withHeader('Content-Type', 'text/html')->withStatus(400);
}

function response_okay(&$response, $tojson)
{
    $response->getBody()->write(json_encode($tojson));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
}

//STUDENT -----------------------
$app->get('/student', function (Request $request, Response $response, $args) {
    //return json array of all students [{roll,name,class,sec}]
    $errstr = "";
    $query = 'select s.roll,s.name,c.class,c.sec from student as s, class as c where s.csi=c.csi order by s.roll asc';
    $result = my_query($query, $errstr);
    if ($result) {
        $resarray = array();
        while ($row = pg_fetch_assoc($result)) {
            $resarray[] = $row;
        }
        return response_okay($response, $resarray);
    } else {
        return response_error($response, "There was some problem with the database.", $errstr);
    }
});

$app->post('/student', function (Request $request, Response $response, $args) {
    $data = json_decode($request->getBody(), true);
    $errstr = "";

    $query = "select csi from class where class={$data['class']} and sec='{$data['sec']}'";
    $csi_res = my_query($query, $errstr);
    if ($csi_res) {
        $csi_fetch = pg_fetch_row($csi_res)[0];
    } else {
        $csi_fetch = false;
    }

    //echo "csi query res is ".$csi_res." with error ".pg_result_error($csi_res)."\n";
    //echo "fetched csi " . $csi_fetch . " ..\n";

    if (!$csi_fetch) {
        $csi_res = my_query('select max(csi) from class', $errstr);
        //echo "csi new fetch query res is ".$csi_res." with error ".pg_result_error($csi_res)."\n";

        if ($csi_res) {
            $csi = pg_fetch_row($csi_res)[0]+1;
            //echo "found out new csi to be ".$csi."\n";
            $flag_insert_csi = true;
        } else {
            return response_error($response, "There was a problem fetching details.", $errstr);
        }
    } else {
        //echo "csi already present as ".$csi_fetch."\n";
        $csi = $csi_fetch;
        $flag_insert_csi = false;
    }

    //echo "finally csi is ".$csi . " ..\n";

    $result = my_query("BEGIN", $errstr);
    if (!$result) {
        return response_error($response, "There was some problem in starting transaction.", $errstr);
    }

    //echo "begin trn res is ".$result." with error ".pg_result_error($result)."\n";

    if ($flag_insert_csi) {
        $class_insert_res = my_query("insert into class (csi,class,sec) values ({$csi},{$data['class']},'{$data['sec']}')", $errstr);
    } else {
        $class_insert_res = true;
    }

    //echo "class insert res is ".$class_insert_res." with error ".pg_result_error($class_insert_res)."\n";

    $student_insert_res = my_query("insert into student (roll,name,csi) values ({$data['roll']},'{$data['name']}',{$csi})", $errstr);

    //echo "student insert res is ".$student_insert_res." with error ".pg_result_error($student_insert_res)."\n";

    if (!$class_insert_res or !$student_insert_res) {
        $roll_trns = my_query("ROLLBACK", $errstr);
        //echo "roll back res is ".$roll_trns." with error ".pg_result_error($roll_trns)."\n";
        if (!$roll_trns) {
            return response_error($response, "Error in Rolling back transaction.", $errstr);
        } else {
            return response_okay($response, "Error in inserting to DB.", $errstr);
        }
    } else {
        $comm_trns = my_query("COMMIT", $errstr);
        if (!$comm_trns) {
            return response_error($response, "Error in commiting transaction.", $errstr);
        }
    }
    return response_okay($response, ["user_msg"=>"Successfully inserted data."]);
});
$app->delete('/student', function (Request $request, Response $response, $args) {
});
$app->put('/student', function (Request $request, Response $response, $args) {
});

//STUDENT xxxxxxxxxxxxxxxxxxxxxxx





//final run
$app->run();
//disconnect
pg_close($dbconn);
