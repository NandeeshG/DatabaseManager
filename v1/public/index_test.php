<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = AppFactory::create();

$dbconn = pg_connect("host=localhost dbname=test user=nandeesh password=789&*(") or die('Could not connect: '.pg_last_error());

/*   //SWITCH ON THIS PART LATER (used to reset dbms on server initialisation)
$deletealltables = '''DO $$ DECLARE
r RECORD;
BEGIN
-- if the schema you operate on is not "current", you will want to
-- replace current_schema() in query with 'schematodeletetablesfrom'
-- *and* update the generate 'DROP...' accordingly.
FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
    EXECUTE 'DROP TABLE IF EXISTS ' || quote_ident(r.tablename) || ' CASCADE';
END LOOP;
END $$;''';
$result = pg_query($deletealltables) or die('Cannot reset DB: '.pg_last_error());

//for this database with that name should already be created
$makeschemafromdump = shell_exec('psql -U nandeesh school < ../schooldb_dump.pgsql')
//also there are some considerations for the owner... so need to run all this manually once.
*/

$query = 'select * from t1';
$result = pg_query($query) or die('Query failed: '.pg_last_error());

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("<h1>HOMEPAGE</h1>");
    return $response->withHeader('Content-Type', 'text/html');
});
$app->get('/select', function (Request $request, Response $response, $args) {
    $data = json_decode($request->getBody(), true);
    //echo $data['query'];

    $query = "select ".$data['query']." from t1";
    $result = pg_query($query);
    if ($result) {
        $myarray = array();
        while ($row = pg_fetch_assoc($result)) {
            $myarray[] = $row;
        }
        pg_free_result($result);
        $response->getBody()->write(json_encode($myarray));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write(pg_last_error());
        return $response->withHeader('Content-Type', 'text/html')->withStatus(400);
    }
});

$app->get('/insert', function (Request $req, Response $res) {
    $data = json_decode($request->getBody(), true);
    $name = 'newentry';
    $age = "12";
    $query = 'select max(roll) from t1';
    $view = pg_query($query);
    if (!$view) {
        $res->getBody()->write("cannot get roll ".$view);
        return $res->withStatus(500);
    } else {
        $roll = pg_fetch_row($view)[0]+1;
    }
    $ret = pg_insert($GLOBALS['dbconn'], 't1', ["name"=>$name,"age"=>$age,"roll"=>$roll]);
    if ($ret) {
        $res->getBody()->write("INSERTED");
        return $res->withHeader('Content-Type', 'text/html');
    } else {
        $res->getBody()->write("FAILED ".$roll);
        return $res->withHeader('Content-Type', 'text/html');
    }
});

$app->run();
pg_close($dbconn);



//$data = json_decode($request->getBody(),true);
//echo $data['query'];
