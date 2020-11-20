--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: class; Type: TABLE; Schema: public; Owner: nandeesh
--

CREATE TABLE public.class (
    csi integer NOT NULL,
    class integer NOT NULL,
    sec character(1) NOT NULL,
    CONSTRAINT ck_name CHECK ((sec ~ '[A-F]'::text)),
    CONSTRAINT class_class_check CHECK (((class > 0) AND (class < 13)))
);


ALTER TABLE public.class OWNER TO nandeesh;

--
-- Name: student; Type: TABLE; Schema: public; Owner: nandeesh
--

CREATE TABLE public.student (
    roll integer NOT NULL,
    name character varying(30) NOT NULL,
    csi integer NOT NULL,
    CONSTRAINT student_name_check CHECK (((name)::text ~ '[a-zA-Z]+[a-zA-Z.-]*'::text))
);


ALTER TABLE public.student OWNER TO nandeesh;

--
-- Name: teacher; Type: TABLE; Schema: public; Owner: nandeesh
--

CREATE TABLE public.teacher (
    tid character varying(20) NOT NULL,
    name character varying(30) NOT NULL,
    CONSTRAINT teacher_name_check CHECK (((name)::text ~ '[a-zA-Z]+[a-zA-Z.-]*'::text)),
    CONSTRAINT teacher_tid_check CHECK (((tid)::text ~ '[a-zA-Z0-9]+'::text))
);


ALTER TABLE public.teacher OWNER TO nandeesh;

--
-- Name: teacherassigned; Type: TABLE; Schema: public; Owner: nandeesh
--

CREATE TABLE public.teacherassigned (
    tid character varying(20),
    csi integer
);


ALTER TABLE public.teacherassigned OWNER TO nandeesh;

--
-- Data for Name: class; Type: TABLE DATA; Schema: public; Owner: nandeesh
--

COPY public.class (csi, class, sec) FROM stdin;
\.


--
-- Data for Name: student; Type: TABLE DATA; Schema: public; Owner: nandeesh
--

COPY public.student (roll, name, csi) FROM stdin;
\.


--
-- Data for Name: teacher; Type: TABLE DATA; Schema: public; Owner: nandeesh
--

COPY public.teacher (tid, name) FROM stdin;
\.


--
-- Data for Name: teacherassigned; Type: TABLE DATA; Schema: public; Owner: nandeesh
--

COPY public.teacherassigned (tid, csi) FROM stdin;
\.


--
-- Name: class class_pkey; Type: CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.class
    ADD CONSTRAINT class_pkey PRIMARY KEY (csi);


--
-- Name: student student_pkey; Type: CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.student
    ADD CONSTRAINT student_pkey PRIMARY KEY (roll);


--
-- Name: teacher teacher_pkey; Type: CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.teacher
    ADD CONSTRAINT teacher_pkey PRIMARY KEY (tid);


--
-- Name: student student_csi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.student
    ADD CONSTRAINT student_csi_fkey FOREIGN KEY (csi) REFERENCES public.class(csi);


--
-- Name: teacherassigned teacherassigned_csi_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.teacherassigned
    ADD CONSTRAINT teacherassigned_csi_fkey FOREIGN KEY (csi) REFERENCES public.class(csi);


--
-- Name: teacherassigned teacherassigned_tid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nandeesh
--

ALTER TABLE ONLY public.teacherassigned
    ADD CONSTRAINT teacherassigned_tid_fkey FOREIGN KEY (tid) REFERENCES public.teacher(tid);


--
-- PostgreSQL database dump complete
--

