--
-- PostgreSQL database dump
--

\restrict UG0zrRUKnAcY6uKreUHFQmsx81YpCU7fL83eJlFDjXp4Flu2KyZpSdunDfJtMlf

-- Dumped from database version 17.6 (Debian 17.6-2.pgdg13+1)
-- Dumped by pg_dump version 17.6 (Debian 17.6-2.pgdg13+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: categories; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: evidence_attachments; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evidence_attachments (
    id bigint NOT NULL,
    evidence_id bigint NOT NULL,
    path character varying(255) NOT NULL,
    original_filename character varying(255) NOT NULL,
    "position" smallint DEFAULT '0'::smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: evidence_attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.evidence_attachments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: evidence_attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.evidence_attachments_id_seq OWNED BY public.evidence_attachments.id;


--
-- Name: evidences; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evidences (
    id bigint NOT NULL,
    title character varying(150) NOT NULL,
    activity character varying(150) NOT NULL,
    description text,
    evidence_date date NOT NULL,
    file_path character varying(255) NOT NULL,
    original_filename character varying(255) NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    participant_id bigint,
    evidence_type character varying(255) DEFAULT 'individual'::character varying NOT NULL,
    participant_name character varying(255)
);


--
-- Name: evidences_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.evidences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: evidences_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.evidences_id_seq OWNED BY public.evidences.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: publication_images; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.publication_images (
    id bigint NOT NULL,
    publication_id bigint NOT NULL,
    path character varying(255) NOT NULL,
    original_filename character varying(255) NOT NULL,
    "position" smallint DEFAULT '0'::smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: publication_images_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.publication_images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: publication_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.publication_images_id_seq OWNED BY public.publication_images.id;


--
-- Name: publications; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.publications (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    excerpt text,
    content text NOT NULL,
    image_path character varying(255),
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    published_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    authors character varying(500),
    category_id bigint,
    activity_date date
);


--
-- Name: publications_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.publications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: publications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.publications_id_seq OWNED BY public.publications.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    is_admin boolean DEFAULT false NOT NULL
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: evidence_attachments id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidence_attachments ALTER COLUMN id SET DEFAULT nextval('public.evidence_attachments_id_seq'::regclass);


--
-- Name: evidences id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidences ALTER COLUMN id SET DEFAULT nextval('public.evidences_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: publication_images id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publication_images ALTER COLUMN id SET DEFAULT nextval('public.publication_images_id_seq'::regclass);


--
-- Name: publications id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publications ALTER COLUMN id SET DEFAULT nextval('public.publications_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.categories (id, name, created_at, updated_at) FROM stdin;
1	Ponencias	2026-11-18 01:03:47	2026-11-18 01:03:47
2	Talleres	2026-11-18 01:03:47	2026-11-18 01:03:47
3	Bingo	2026-11-18 01:03:47	2026-11-18 01:03:47
4	Feria de proyectos	2026-11-18 01:03:47	2026-11-18 01:03:47
5	Comelona de pizza	2026-11-18 01:03:47	2026-11-18 01:03:47
6	Torneo de fútbol sala	2026-11-18 01:03:47	2026-11-18 01:03:47
7	Parrillada	2026-11-18 01:03:47	2026-11-18 01:03:47
8	Actividad	2026-11-18 01:03:47	2026-11-18 01:03:47
9	Damos inicio a la Semana de Sistemas 2026, un espacio dedicado a la innovación tecnológica, el apren	2026-11-18 01:03:47	2026-11-18 01:03:47
\.


--
-- Data for Name: evidence_attachments; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.evidence_attachments (id, evidence_id, path, original_filename, "position", created_at, updated_at) FROM stdin;
1	4	evidencias/rmaE0h44pqaCkwQpOpuqjoXy70yj0wmEixxA8Uhm.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (2).jpeg	0	2026-11-19 03:24:59	2026-11-19 03:24:59
2	4	evidencias/xv7RTG5AePy9he3XfbwiQ6rQbeHR9m39I7Bfra87.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (4).jpeg	1	2026-11-19 03:24:59	2026-11-19 03:24:59
3	4	evidencias/amQotVX2TfWGr5TrCj0fHnoAKrEbSaVSKMShWemV.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (5).jpeg	2	2026-11-19 03:24:59	2026-11-19 03:24:59
4	4	evidencias/EGBccmNBwChBrOeSWue4IH6DSNAmTAKEtSg8As4R.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (6).jpeg	3	2026-11-19 03:24:59	2026-11-19 03:24:59
5	4	evidencias/yOvyWmOTk5vYzkV8xwi88b8IeYQIIvEli5IAwmAw.jpg	WhatsApp Image 2026-11-17 at 14.35.26.jpeg	4	2026-11-19 03:24:59	2026-11-19 03:24:59
6	3	evidencias/B4wsfW3HWleLeBeqRsEfuojipcNG8RHFC51ILVyr.jpg	WhatsApp Image 2026-11-19 at 22.34.29.jpeg	0	2026-11-20 04:36:00	2026-11-20 04:36:00
7	3	evidencias/IrnYUKsdpHIwtkMS5kxAYh61luKoLJKv6oXinUXw.jpg	WhatsApp Image 2026-11-19 at 22.35.40.jpeg	1	2026-11-20 04:36:00	2026-11-20 04:36:00
8	6	evidencias/r3ljUpnuE6SX7v1Gg2xemUwINhr5PePw8FT83Kco.jpg	8a21b9ca-0732-41a2-931c-87f92b0f5b2f.jpeg	0	2026-11-20 04:47:06	2026-11-20 04:47:06
9	9	evidencias/PnFoIrKsVIB2HhkmeT6twN2xl6RWv9enpM3AvALQ.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (3).jpeg	0	2026-11-20 04:52:55	2026-11-20 04:52:55
10	11	evidencias/dI7xGl8qpwD0oOQJUjlKjbj0e0m6oGt8nAJfoSG5.jpg	WhatsApp Image 2026-11-19 at 22.59.59.jpeg	0	2026-11-20 05:05:47	2026-11-20 05:05:47
11	11	evidencias/nBMMW9PGuAjbJNEs99G6BsgaSYmZNxA2Prua977y.jpg	WhatsApp Image 2026-11-19 at 22.58.38.jpeg	1	2026-11-20 05:05:47	2026-11-20 05:05:47
12	11	evidencias/GGHpD72isf4hJlhzQpKbfFQIyYuWVW0DAAY5sk5J.jpg	WhatsApp Image 2026-11-19 at 22.58.31.jpeg	2	2026-11-20 05:05:47	2026-11-20 05:05:47
13	11	evidencias/yWMzHmMyX4wGR2DcIzYl61pj2tiQsdPlx7V4lP9h.jpg	WhatsApp Image 2026-11-19 at 18.11.04 (1).jpeg	3	2026-11-20 05:05:47	2026-11-20 05:05:47
14	10	evidencias/TxuFapJ2Q3efodnoxazRaXk93QZ3cxH8QcHYGWai.jpg	WhatsApp Image 2026-11-19 at 21.33.20 (1).jpeg	0	2026-11-20 05:06:30	2026-11-20 05:06:30
15	12	evidencias/mbwLc3IIBHnG5rlt9bKJsALWs5bX18fQabe0i7Er.jpg	WhatsApp Image 2026-11-19 at 23.09.30 (1).jpeg	0	2026-11-20 05:10:20	2026-11-20 05:10:20
16	12	evidencias/UZKWOT07i3GdyEMbVRBhS3FP1DWfr4yAqTTL6Vmb.jpg	WhatsApp Image 2026-11-19 at 23.09.30.jpeg	1	2026-11-20 05:10:20	2026-11-20 05:10:20
17	14	evidencias/wtacZmEUUt2HQx9T4FMiPdJJburm9JuaoUL5W5lI.jpg	oit2.jpeg	0	2026-11-21 05:13:06	2026-11-21 05:13:06
18	15	evidencias/ErAHm8HpxPLCL5xEA7yE26wZlsJ37n1Q4LbWDUdo.jpg	energias1.jpeg	0	2026-11-21 05:19:07	2026-11-21 05:19:07
19	16	evidencias/qHqtjGpV1K6bLhFNcDM3enbizdA8ZHQfPcrxOtPW.jpg	app.jpeg	0	2026-11-21 05:27:25	2026-11-21 05:27:25
20	17	evidencias/wpoRfPTktHXFedxEIXZRBGrjS83dxXwheM09lNHR.jpg	pishin.jpeg	0	2026-11-21 05:33:52	2026-11-21 05:33:52
21	18	evidencias/yR7AigYRmgxPMfZgTrCrMGSAGsnRBszPXlQS7O3a.jpg	maps1.jpeg	0	2026-11-21 05:38:43	2026-11-21 05:38:43
22	19	evidencias/05zEjbyq4S7TaOSxXRI0J9ZjeQLY5YEo1QlUlE2D.jpg	Bingo.jpeg	0	2026-11-21 05:44:12	2026-11-21 05:44:12
23	19	evidencias/aDjhfgN9S6HwOXkSiqGezHJ8Ewn5cO2UKEOR8DVb.jpg	Bingo2.jpeg	1	2026-11-21 05:44:12	2026-11-21 05:44:12
24	20	evidencias/kalyrVfJcwxVSWa6OfWQRLLLkC9Yut6K9cdXJbPN.jpg	WhatsApp Image 2026-11-20 at 11.50.12 PM (1).jpeg	0	2026-11-21 05:51:15	2026-11-21 05:51:15
25	20	evidencias/qV4SQNGNhvHZH9HAYAOJvng7eEMbZ0BJOQWOA2du.jpg	WhatsApp Image 2026-11-20 at 11.50.12 PM (2).jpeg	1	2026-11-21 05:51:15	2026-11-21 05:51:15
26	20	evidencias/5yvdXQCTn0jVUY2tDVRfIO0J0WRaUI7dN05x4rfR.jpg	WhatsApp Image 2026-11-20 at 11.50.12 PM.jpeg	2	2026-11-21 05:51:15	2026-11-21 05:51:15
27	21	evidencias/hEpj4N0ock0s2lOgvUYm0a7yEiyZXRCFjk5Oqt1d.jpg	comelona.jpeg	0	2026-11-21 05:56:46	2026-11-21 05:56:46
28	21	evidencias/Ru1Uh8NQSc46S7Tj0EtKwRLgqKu7LWhIzFhbIsBL.jpg	comelona1.jpeg	1	2026-11-21 05:56:46	2026-11-21 05:56:46
29	22	evidencias/qY0kInfOKVPELCHHZ6DJ1JRPoPL1MPCTP8Kg6zIl.jpg	copa.jpeg	0	2026-11-21 06:02:21	2026-11-21 06:02:21
30	22	evidencias/FtrI6RH7CtVcrIEIcHpWSPFLfrhDRcPafI7wcTdL.jpg	segundo lugar.jpeg	1	2026-11-21 06:02:21	2026-11-21 06:02:21
31	24	evidencias/N6ch307btRZR5f1HrINt21BvwVWt0x0kctdZlteF.jpg	Futsal.jpeg	0	2026-11-21 06:20:19	2026-11-21 06:20:19
32	25	evidencias/tp3BjeSccAsmGwyAO4evCflB6J7XXOuErElcR5ao.jpg	parrillada 2.jpeg	0	2026-11-21 06:25:35	2026-11-21 06:25:35
\.


--
-- Data for Name: evidences; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.evidences (id, title, activity, description, evidence_date, file_path, original_filename, user_id, created_at, updated_at, participant_id, evidence_type, participant_name) FROM stdin;
3	Inauguración de la Semana de Sistemas 2026	Acto de inauguración	Participación en el acto de inauguración de la Semana de Sistemas 2026, dando inicio a las actividades académicas y tecnológicas organizadas por la carrera de Ingeniería de Sistemas Informáticos.	2026-11-16	evidencias/755zmM7RqUhHQPCd63LTDBdqqBKHAqGlTCDLTYMU.jpg	26d75a58-b524-4133-998e-614b3ea5cd75.jpeg	1	2026-11-19 03:03:02	2026-11-19 03:03:50	\N	individual	Isaias Leonel Cañas Rosa
4	Ponencia 1 – Investigación aplicada en IoT para la agricultura en El Salvador	Ponencia académica sobre Internet de las Cosas (IoT) aplicado a la agricultura.	Participación en la ponencia sobre investigación aplicada en Internet de las Cosas (IoT) para la agricultura en El Salvador, conociendo aplicaciones tecnológicas e innovaciones que contribuyen al desarrollo del sector agrícola.	2026-11-16	evidencias/q8vSEaKIcIbO0J2lwUJow0MRoKMTcxDkMztFknQq.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (6).jpeg	1	2026-11-19 03:04:46	2026-11-19 03:17:25	\N	individual	Isaias Leonel Cañas Rosa
6	Ponencia 3 – Eficiencia energética, optimización de recursos y sostenibilidad aplicada a soluciones	Ponencias	Participación en la ponencia sobre eficiencia energética, optimización de recursos y sostenibilidad aplicada a soluciones tecnológicas, impartida por el Lic. Nahum Alexander Sánchez Cruz. Durante la actividad se conocieron aplicaciones del Internet de las Cosas (IoT) para automatizar y monitorear sistemas de climatización, así como la integración de sensores, actuadores, redes de comunicación y herramientas de software para mejorar el uso de los recursos energéticos.	2026-11-17	evidencias/zMBnC2cFO5dTgDEVh3MvIfhJacfifE0zaxhN9Sxu.jpg	WhatsApp Image 2026-11-19 at 19.03.25.jpeg	1	2026-11-20 04:45:45	2026-11-20 04:45:45	\N	individual	Isaias Leonel Cañas Rosa
5	Ponencia 2 – Eficiencia energética y energías renovables	Ponencias	Participación en la ponencia sobre eficiencia energética y energías renovables, donde se abordaron ejemplos de aplicación del Internet de las Cosas (IoT), como el monitoreo del consumo de aire acondicionado, la conexión de dispositivos mediante redes IP y el uso de objetos inteligentes. También se conocieron ejemplos de aprovechamiento de energía mediante el movimiento al caminar y el uso de fuentes renovables como la energía eólica e hidroeléctrica.	2026-11-16	evidencias/tlsINMvY1AqXep1VS5XWt2lNzoBKYyBR34cYfiQo.jpg	WhatsApp Image 2026-11-19 at 18.47.37.jpeg	1	2026-11-20 04:42:18	2026-11-20 04:46:11	\N	individual	Isaias Leonel Cañas Rosa
7	Ponencia 4 – Ciberseguridad, inteligencia artificial y gestión del riesgo en las organizaciones	Ponencias	Participación en la ponencia sobre ciberseguridad, inteligencia artificial y gestión del riesgo en las organizaciones, desarrollada por Victoria Rivas y Edwin Umaña. Durante la actividad se abordaron temas relacionados con los correos maliciosos, la identificación de ataques de phishing, los riesgos asociados al comportamiento humano y la importancia de la gestión de riesgos. También se realizó una dinámica práctica para reconocer posibles correos fraudulentos y se presentaron recomendaciones de actuación ante un incidente de ciberseguridad.	2026-11-17	evidencias/otHs0kWNPpbFiskr6MWS9tPZzbetGLYlHQbRR5mC.jpg	WhatsApp Image 2026-11-19 at 20.46.16.jpeg	1	2026-11-20 04:49:14	2026-11-20 04:49:14	\N	individual	Isaias Leonel Cañas Rosa
9	Gran Bingo – Semana de Sistemas SDS26 GREEN IoT	Bingo	Participación en el Gran Bingo de la Semana de Sistemas SDS26 GREEN IoT, desarrollado en el Auditorio 1 de la Facultad Multidisciplinaria Oriental. Durante esta actividad recreativa se utilizó una plataforma digital a la que los participantes podían ingresar mediante un código QR o código de sala. La dinámica permitió utilizar cartones de bingo digitales, visualizar los números sorteados y marcarlos en tiempo real, promoviendo la convivencia y la integración entre los asistentes.	2026-11-18	evidencias/wNo0hpuw3taChVG7jfnTj8fRgrvyWPhLT0cDkpXy.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (4).jpeg	1	2026-11-20 04:52:10	2026-11-20 04:52:55	\N	individual	Isaias Leonel Cañas Rosa
8	Taller – Sostenibilidad y análisis energético mediante Electricity Maps	Talleres	Participación en el taller sobre sostenibilidad y análisis energético mediante Electricity Maps, donde se exploró el uso de esta herramienta para analizar la intensidad de carbono de la electricidad y la composición de las fuentes de generación energética. También se desarrollaron ejemplos prácticos relacionados con el consumo de energía de equipos informáticos en reposo y la aplicación de sensores para optimizar su funcionamiento, reducir el consumo eléctrico y contribuir a la sostenibilidad tecnológica.	2026-11-17	evidencias/eknampPbf0E1vwywm6ZBqFhcFhYaNs9rt9XNiuuf.jpg	688997d2-7467-46ab-bc45-d994ef588e72.jpeg	1	2026-11-20 04:50:21	2026-11-20 04:53:25	\N	individual	Isaias Leonel Cañas Rosa
10	EXPO SYSTEM 2026 – Organización y apoyo en la feria de proyectos	Feria de proyectos	Participación en la organización y desarrollo de EXPO SYSTEM 2026, actividad de la Semana de Sistemas SDS26 GREEN IoT de la UES-FMO. Como parte de la colaboración, apoyamos en los preparativos del evento mediante el traslado y colocación de sillas, así como en el armado de los canopy para acondicionar los espacios donde se desarrollarían las actividades. Posteriormente, participamos en la jornada de exhibición de proyectos tecnológicos elaborados por estudiantes de Ingeniería de Sistemas Informáticos, conociendo propuestas e innovaciones desarrolladas durante su formación académica.	2026-11-18	evidencias/K6nxQDgLr2bu3dsHWRTJjs8djeVVquDoZds1WEw9.jpg	WhatsApp Image 2026-11-19 at 21.33.21 (2).jpeg	1	2026-11-20 04:55:29	2026-11-20 04:55:29	\N	individual	Isaias Leonel Cañas Rosa
11	EXPO SYSTEM 2026 – Recorrido por los stands y proyectos tecnológicos	Feria de proyectos	Participación en EXPO SYSTEM 2026, realizando un recorrido por los diferentes stands de la feria de proyectos de Ingeniería de Sistemas Informáticos de la UES-FMO. Durante la jornada tuve la oportunidad de conocer los proyectos desarrollados por los estudiantes, observar sus demostraciones, escuchar las explicaciones de sus integrantes y conocer distintas propuestas tecnológicas e innovadoras relacionadas con las áreas de formación de la carrera.	2026-11-19	evidencias/uQ6vbfhW09nymZfFVFqPJ1g5Uc2f5UjA3RNk32Me.jpg	WhatsApp Image 2026-11-19 at 22.58.31.jpeg	1	2026-11-20 05:00:33	2026-11-20 05:00:33	\N	individual	Isaias Leonel Cañas Rosa
12	EXPO SYSTEM 2026 – Apoyo en la animación y conducción del evento	Feria de proyectos	Participación como apoyo en la animación y conducción de EXPO SYSTEM 2026, durante la jornada de exhibición de proyectos tecnológicos de Ingeniería de Sistemas Informáticos de la UES-FMO. Colaboré anunciando los diferentes proyectos, brindando palabras de bienvenida e invitando a estudiantes de las demás carreras de la Facultad Multidisciplinaria Oriental a acercarse y conocer las propuestas presentadas. Esta experiencia permitió fortalecer mis habilidades de comunicación, expresión oral y participación en actividades académicas.	2026-11-19	evidencias/flnRWEgSOQPKmkcmgX2rvZWMAwtnfRNCAqJGfqZc.jpg	WhatsApp Image 2026-11-19 at 23.08.43.jpeg	1	2026-11-20 05:10:20	2026-11-20 05:10:20	\N	individual	Isaias Leonel Cañas Rosa
13	Comelona Pizza 2026 – Semana de Sistemas SDS26 GREEN IoT	Comelona de pizza	Participación en la actividad recreativa Comelona Pizza 2026, desarrollada como parte de la Semana de Sistemas SDS26 GREEN IoT. Tambien estuve como animador, Durante esta dinámica se realizó una competencia en la que los participantes debían terminar su pizza dentro de un tiempo establecido de 15 minutos. La actividad estuvo llena de emoción, entusiasmo y diversión, promoviendo la convivencia y la integración entre estudiantes y participantes de la comunidad universitaria. El primer lugar fue obtenido por el Ing. José Alexander Guandique Flores.	2026-11-20	evidencias/1Y5QTElkQgrn4zJIVwaDRGU0eu00vKjJQ5fizbIk.jpg	WhatsApp Image 2026-11-19 at 23.09.30.jpeg	1	2026-11-20 05:13:00	2026-11-20 05:13:00	\N	individual	Isaias Leonel Cañas Rosa
14	Ponencia: Investigacion aplicada para la IOT para la agricultura en el salvador	Ponencias	Fue una charla muy interesante ya que se hablo de como la tecnologia aplicada a las cosas esta ayudando a la agricultura de nuestro pais y ademas de eso como no solamente a la agricultura sino tambien al medioambiente como se menciono a las tortugas que desoban y ayudan al ecosistema ademas de ayudar en el monitoreo de la calidad del aire con estaciones mas especificamente en la ciudad de San Miguel entonces eso es muy interesante ya que vemos con la IOT puede ser beneficiosa para los salvadoreños en general	2026-11-16	evidencias/ucof18LV9aC41OpTEXHdcs4QeFizoGIo7DNTv0rK.jpg	IOT.jpeg	1	2026-11-21 05:13:06	2026-11-21 05:13:06	\N	individual	Jairo Jair Ortiz Santos
15	Ponencia 2: Eficiencia energética y energías renovables	Ponencias	Una charla donde se nos menciono algo muy interesante algo que me gusto mucho fue que el ponente nos menciono que como ciudadanos deberiamos en cosas que podrian parecer  basicas como el aire acondicionado deberiamos tener un poco mas de conciencia a la hora de usarlos asi como investigar sobre como podriamos mejor nuestra eficiencia energetica con electrodomesticos mas eficiente	2026-11-16	evidencias/LPcMY90axxYXEUeu8tVuyFT09b1tsjx1mjQ5iydV.jpg	energias.jpeg	1	2026-11-21 05:19:07	2026-11-21 05:19:39	\N	individual	Jairo Jair Ortiz Santos
16	Ponencia 3: Eficiencia Energética, Optimización de Recursos y Sostenibilidad Aplicada a Soluciones Tecnológicas	Ponencias	Fue una ponencia donde el Lic Naum nos comento como ellos desde su lugar de trabajo implementaron un sistema donde se permitia monitorea desde una app los aires acondicionados y apagarlos o encenderlos de manera controlada asi reduciendo la cantidad de horas que podrian pasar encendidos sin que alguien los estuviera necesitando	2026-11-17	evidencias/ydWOL2q7P06uidCnRyMBjXfnOJ5lrn8nTrdrnVQV.jpg	aire.jpeg	1	2026-11-21 05:27:25	2026-11-21 05:27:25	\N	individual	Jairo Jair Ortiz Santos
17	Ponencia 4: Tecnologia conectada para un futuro sostenible	Ponencias	Creo que fue una de las ponencias mas interesante tanto como la ponente se expresaba cautivaba la atencion asi como las dinamicas que hicieron creo que como estudiantes debemos tener en cuenta como lo son los ataques ciberneticos donde hay canales por los cuales podemos caer algunas cosas interesantes fue aprender a como detectar correos falso como verificar el nombre del emisor si posee dominio entre muchas otras cosas, fue una de mis ponencias favoritas	2026-11-17	evidencias/UOILc4jQ0ay9eA2yOpmQRELIh3vFXh3xLuWHB5ex.jpg	asset.jpeg	1	2026-11-21 05:33:52	2026-11-21 05:33:52	\N	individual	Jairo Jair Ortiz Santos
18	Ponencia: Sostenibilidad Digital y Análisis Energético mediante Electricity Maps	Talleres	Un taller muy interesante usando Electricity Maps una pagina web donde pudimos descubrir como se genera la electricidad de cada region del mundo y de que fuentes son las que se usan mayormente entre otras estadisticas	2026-11-17	evidencias/Acpv3mEuhJ8zOB8m8kaHLTd0A7JCq1ebTT1eEcEu.jpg	maps.jpeg	1	2026-11-21 05:38:43	2026-11-21 05:38:43	\N	individual	Jairo Jair Ortiz Santos
19	Bingo !!	Bingo	Luego de las ponencias pudimos tener un momento muy anemo entre los estudiantes de la carrera y disfrutar de un Bingo donde se estuvieron ganando premios aunque yo no gane ninguno pero la experiencia fue inolvidable	2026-11-18	evidencias/6uqEct2rWqO9VAxBuumcKVxMKEdsj4Lw8vxaj9B3.jpg	Bingo2.jpeg	1	2026-11-21 05:44:12	2026-11-21 05:44:12	\N	individual	Jairo Jair Ortiz Santos
20	Feria de Logros	Feria de proyectos	En la feria pude presentar mi proyecto de la materia de Arquitectura de Computadoras titulado "Monitor Solar" el cual era un sistema compuesto por 2 sensores uno de balancin y uno de voltaje que median la cantidad generada por el panel solar fue una de las experiencias mas gratas poder explicarles a personas de otras carreras como y que hacemos en ingenieria de sistemas informarticos y compartir con nuestros compañeros de otros años y ver que en la FMO hay talento para transformar nuestro pais	2026-11-19	evidencias/OIKDMeWxxEwxIGO2m1qRgHTAk0Sp2CiSw9HaoR3X.jpg	feria de logros.jpeg	1	2026-11-21 05:51:15	2026-11-21 05:51:15	\N	individual	Jairo Jair Ortiz Santos
21	Comelona de pizza	Comelona de pizza	Luego de la feria de logros vino una de las partes mas interesantes como fue ver a nuestros compañeros competir por ver quien comia mas pizza en menos tiempo	2026-11-19	evidencias/mnIYu18zAdjU58BUKqzfmkmsh1B1xBzOdYoVjeuq.jpg	ganador.jpeg	1	2026-11-21 05:56:46	2026-11-21 05:56:46	\N	individual	Jairo Jair Ortiz Santos
22	FutSal	Torneo de fútbol sala	Uno de los momentos mas divertidos aunque no me gusta jugar futbol pero disfrute mucho ver como los demas equipos daban todo en la cancha para ganar eso ayuda a que como estudiantes nos dejemos de lado un poco el estres por las tareas y podamos tambien disfrutar y hacer amigos de otras carreras mediante el futbol donde el ganador fue el equipo de Jefry y sus amigos	2026-11-20	evidencias/2gyo8WwlRKItWQ9r5cH05LqGrXTbhcstIFUx9bUD.jpg	ganadorfutbol.jpeg	1	2026-11-21 06:02:21	2026-11-21 06:02:21	\N	individual	Jairo Jair Ortiz Santos
23	Parrillada	Parrillada	Luego para finalizar todas las actividades de la SDS 2026 pudimos disfrutar de una parrillada elaborada por el Ing Diego donde pudimos compartir con nuestros compañeros de la carrera de una rico almuerzo	2026-11-20	evidencias/twvU54RhVNSpnYayZw8w4D1U4KdfLxaVVYpQNsBy.jpg	parrillada.jpeg	1	2026-11-21 06:04:54	2026-11-21 06:04:54	\N	individual	Jairo Jair Ortiz Santos
24	Participacion en el Torneo de Futsal	Torneo de fútbol sala	Participacion en el torneo de Futsal realizado como parte de las actividades deportivas de la semana de Sistema 2026.  \r\nLos equipos fueron Legion 7 vs Token FC Industriales vs Jefrey y sus amigos  y Docker Composer.yml vs City rojo al final gano Jefry y sus amigos	2026-11-21	evidencias/xddFndmE6AxC7GiLLQRFlR9Kr5kY5J4zjUn6Uhnk.jpg	WhatsApp Image 2026-11-20 at 11.24.40 PM.jpeg	1	2026-11-21 06:20:19	2026-11-21 06:20:47	\N	individual	Isaias Leonel Cañas Rosa
25	Parrillada y Convivencia	Parrillada	Participación en la actividad de convivencia y parrillada organizada durante el ultimo día de la semana de sistemas 2026 Durante esta jornada brinde apoyo en la preparación de platos y de entregas en el personal docente y administrativo.	2026-11-21	evidencias/0PuVwWBdBIFbo2sErGIPwXHGAvQfGuRHKiWla75Z.jpg	parridalla .jpeg	1	2026-11-21 06:25:35	2026-11-21 06:25:35	\N	individual	Isaias Leonel Cañas Rosa
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_11_17_140000_add_role_to_users_table	2
5	2026_11_17_150000_create_publications_table	3
6	2026_11_17_160000_create_evidences_table	4
7	2026_11_17_170000_create_publication_images_table	5
8	2026_11_17_180000_add_authors_to_publications_table	6
9	2026_11_17_190000_create_categories_and_normalize_publications	7
10	2026_11_17_200000_add_activity_date_to_publications	8
11	2026_11_17_210000_create_teams_and_attach_evidence_participants	8
12	2026_11_18_060000_remove_team_management	9
13	2026_11_18_204500_add_evidence_type_to_evidences	10
14	2026_11_18_205000_add_participant_name_to_evidences	11
15	2026_11_18_211800_create_evidence_attachments_table	12
16	2026_11_19_172800_replace_user_role_with_admin_flag	13
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: publication_images; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.publication_images (id, publication_id, path, original_filename, "position", created_at, updated_at) FROM stdin;
3	1	publications/Fuw1b0geYvAILxxhqqJ2cOWWbOUJTV1GqVHDoLit.jpg	593f9be7-a584-4831-8c21-2a78ff537a2b.jpeg	0	2026-11-17 15:34:45	2026-11-17 15:34:45
4	1	publications/4CErd6hx1qThZGPfTNRRcbRLhFutdhLUfo4a9Y0b.jpg	26d75a58-b524-4133-998e-614b3ea5cd75.jpeg	1	2026-11-17 15:34:45	2026-11-17 15:34:45
6	3	publications/yc48V1aGrUq0X4WrCBfISlhlGA6zuOFncTg20IJd.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (1).jpeg	0	2026-11-17 20:41:10	2026-11-17 20:41:10
7	3	publications/fySL7MPTp9t70grAlAsjATiV7ZKTvpdvU8KVEeT9.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (2).jpeg	1	2026-11-17 20:41:10	2026-11-17 20:41:10
8	3	publications/jRjmoJNkopXLfbG783YihcfPaUisQn3RFqqwrH7c.jpg	WhatsApp Image 2026-11-17 at 14.35.26 (5).jpeg	2	2026-11-17 20:41:10	2026-11-17 20:41:10
9	3	publications/MVZ3qJDQ1CmZkcAHUFPtiN3obYgPaVF47TLrCGQq.jpg	WhatsApp Image 2026-11-17 at 14.35.27 (2).jpeg	3	2026-11-17 20:41:10	2026-11-17 20:41:10
10	3	publications/iJOwlcxQuBHfiKGoyThltrjYLJHrv9A3OifVN1Ml.jpg	WhatsApp Image 2026-11-17 at 14.35.27 (3).jpeg	4	2026-11-17 20:41:10	2026-11-17 20:41:10
11	4	publications/2WsuDhT8ASp6jkaOaYicR7dZezzO9mqCobk4ju6u.jpg	WhatsApp Image 2026-11-19 at 18.47.31 (1).jpeg	0	2026-11-20 00:55:33	2026-11-20 00:55:33
12	4	publications/ovLygAArZpRipZNmzfQgY7oFKdqDkkigcQMY6JKn.jpg	WhatsApp Image 2026-11-19 at 18.47.31.jpeg	1	2026-11-20 00:55:33	2026-11-20 00:55:33
13	4	publications/OjhVZvWU20lniO6jZ6xR03PlSNomyCGEHllbvGZe.jpg	WhatsApp Image 2026-11-19 at 18.47.32 (1).jpeg	2	2026-11-20 00:55:33	2026-11-20 00:55:33
14	4	publications/S4f3bicqTTK5T4KzRGc0R6gYaNuIJoErI0HxNNnU.jpg	WhatsApp Image 2026-11-19 at 18.47.32 (2).jpeg	3	2026-11-20 00:55:33	2026-11-20 00:55:33
15	4	publications/VOEM3LnhDFVYdg1hcEtHUp3LVV7MmEi502xmG73w.jpg	WhatsApp Image 2026-11-19 at 18.47.32.jpeg	4	2026-11-20 00:55:33	2026-11-20 00:55:33
16	4	publications/3kV9b8XonxSAzOdb9WnGEA7Gas8BOI4T3PxkR6cE.jpg	WhatsApp Image 2026-11-19 at 18.47.33 (1).jpeg	5	2026-11-20 00:55:33	2026-11-20 00:55:33
17	4	publications/oQA71k7T62hgOS3S53O4TUhW54TaWP9ClLgIfwmE.jpg	WhatsApp Image 2026-11-19 at 18.47.35 (2).jpeg	6	2026-11-20 00:55:33	2026-11-20 00:55:33
18	5	publications/iPGIBwsTbi6Lfvfr7p1zozwX5vZfHbqvMyR0ceKo.jpg	WhatsApp Image 2026-11-19 at 19.03.25 (2).jpeg	0	2026-11-20 01:31:42	2026-11-20 01:31:42
19	5	publications/hiqmrOvW6ywpQ2HhjyMplUDI2ZCIwpzic68JDDxq.jpg	WhatsApp Image 2026-11-19 at 19.03.25 (3).jpeg	1	2026-11-20 01:31:42	2026-11-20 01:31:42
20	5	publications/oyddnVdmQuHmi0adLtlj4UQzBLEzJpjBKDXfk2ko.jpg	WhatsApp Image 2026-11-19 at 19.03.25 (4).jpeg	2	2026-11-20 01:31:42	2026-11-20 01:31:42
21	5	publications/lTmX8fAwVUF7mW12hh8Rerzq98SiILtwtRvwszLu.jpg	WhatsApp Image 2026-11-19 at 19.03.25 (5).jpeg	3	2026-11-20 01:31:42	2026-11-20 01:31:42
22	5	publications/n0n3QVE7d9JbIXUEDKovdUsywPq3945toEPE9z3t.jpg	WhatsApp Image 2026-11-19 at 19.03.25 (6).jpeg	4	2026-11-20 01:31:42	2026-11-20 01:31:42
23	5	publications/2E8SryQI6AfgIh1OczhihabfMhUNH3OTlxntpiuS.jpg	WhatsApp Image 2026-11-19 at 19.03.26 (2).jpeg	5	2026-11-20 01:31:42	2026-11-20 01:31:42
24	5	publications/CCiVz1FhHV9jx1rUpBr7ZD9Fr9fQyziKngIy3Nac.jpg	WhatsApp Image 2026-11-19 at 19.03.26 (3).jpeg	6	2026-11-20 01:31:42	2026-11-20 01:31:42
25	6	publications/B2lAjz9OCGzX8uvOpQdGH5Nbw5xWk2VQnpRbwNqR.jpg	WhatsApp Image 2026-11-19 at 20.46.17 (1).jpeg	0	2026-11-20 02:55:27	2026-11-20 02:55:27
26	6	publications/PlZoltK9BLrelh22lBRZ8xsJr9jlflXWYgQS8DkG.jpg	WhatsApp Image 2026-11-19 at 20.46.17 (2).jpeg	1	2026-11-20 02:55:27	2026-11-20 02:55:27
27	6	publications/Px6fTcb2cwEVduueHNmlAzI04HTGM7P8ysIUJlgX.jpg	WhatsApp Image 2026-11-19 at 20.46.17 (5).jpeg	2	2026-11-20 02:55:27	2026-11-20 02:55:27
28	6	publications/aLvY6TVa1MwuU7xjzrmrVPvxots6mHPjPt3SyZzB.jpg	WhatsApp Image 2026-11-19 at 20.46.17 (6).jpeg	3	2026-11-20 02:55:27	2026-11-20 02:55:27
29	6	publications/7dvXgFY16WZaK06GTNcnbQi4UvaYLoIixtWlzgy5.jpg	WhatsApp Image 2026-11-19 at 20.46.18 (3).jpeg	4	2026-11-20 02:55:27	2026-11-20 02:55:27
30	6	publications/ZUgsENuPmLv07N5E3JeNZyrlzmnklQOgMWFLGdGo.jpg	WhatsApp Image 2026-11-19 at 20.46.18 (4).jpeg	5	2026-11-20 02:55:27	2026-11-20 02:55:27
31	6	publications/72an58w1R5FbBmVOr6bxVDCNIxvyIQubk6lSmd38.jpg	WhatsApp Image 2026-11-19 at 20.46.18 (5).jpeg	6	2026-11-20 02:55:27	2026-11-20 02:55:27
32	6	publications/N2DoMo2eRRZxorl0tBEQNx3U5s4hyGsoDmGKJbtP.jpg	WhatsApp Image 2026-11-19 at 20.46.18.jpeg	7	2026-11-20 02:55:27	2026-11-20 02:55:27
33	7	publications/paq8f3VDoTSKuepjiwCqkLWnCvAFuaIXgjbcX0kc.jpg	WhatsApp Image 2026-11-19 at 21.22.50 (1).jpeg	0	2026-11-20 03:28:58	2026-11-20 03:28:58
34	7	publications/zbUearzWdSBK8exmpg2K1YcWJSKH5barT8FtPSBf.jpg	WhatsApp Image 2026-11-19 at 21.22.50 (2).jpeg	1	2026-11-20 03:28:58	2026-11-20 03:28:58
35	7	publications/MuKRWbycVnD6EEERn2ezGocuNwkQusKoDf4bAWcX.jpg	WhatsApp Image 2026-11-19 at 21.22.50 (3).jpeg	2	2026-11-20 03:28:58	2026-11-20 03:28:58
36	7	publications/mVVb6G5ctXNc2ONOCghYGq6LO1jKNz4RkF7NxPjY.jpg	WhatsApp Image 2026-11-19 at 21.22.50 (5).jpeg	3	2026-11-20 03:28:58	2026-11-20 03:28:58
37	7	publications/LHOchWZ6ZsQ0qbQ0B0PUDot3gyexett072GCONxz.jpg	WhatsApp Image 2026-11-19 at 21.22.50.jpeg	4	2026-11-20 03:28:58	2026-11-20 03:28:58
38	7	publications/DErLob0788joWE0Md9501iVL0iQPfATD2bUIWO5y.jpg	WhatsApp Image 2026-11-19 at 21.22.51 (1).jpeg	5	2026-11-20 03:28:58	2026-11-20 03:28:58
39	7	publications/D9FA0a2CgQeLlMcafQVFKMTGIo9OHYqtDH12LMga.jpg	WhatsApp Image 2026-11-19 at 21.22.51 (3).jpeg	6	2026-11-20 03:28:58	2026-11-20 03:28:58
40	8	publications/qIw70RME3bniMVqUtYtldz0r8yC9J0CcdsLSwh9t.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (1).jpeg	0	2026-11-20 03:44:55	2026-11-20 03:44:55
41	8	publications/QXyqVLAfBC4fFJQgzoprGIPOWbau4ad63qBitlYe.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (2).jpeg	1	2026-11-20 03:44:55	2026-11-20 03:44:55
42	8	publications/CzDsol26S7Fxrhz7fFIIWG7FuSyDGNGTUAhsso2t.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (3).jpeg	2	2026-11-20 03:44:55	2026-11-20 03:44:55
43	8	publications/yle7j5EUUnF9TpO2W7uvNJmlnZMjPSCRXq5ycktK.jpg	WhatsApp Image 2026-11-19 at 21.33.19 (4).jpeg	3	2026-11-20 03:44:55	2026-11-20 03:44:55
44	8	publications/t6GRTp0vW1oyZzR2c1X6xLbaiHrWfiotxQkM1d4X.jpg	WhatsApp Image 2026-11-19 at 21.33.19.jpeg	4	2026-11-20 03:44:55	2026-11-20 03:44:55
45	9	publications/6imXqzZm9F8zoRDip6RddR6b0DcPIWqxD9pHQBW0.jpg	WhatsApp Image 2026-11-19 at 18.10.59 (1).jpeg	0	2026-11-20 04:16:18	2026-11-20 04:16:18
46	9	publications/VCxoolheeTYQacGnrnYq93YANxO7gkc0wuc3bJAt.jpg	WhatsApp Image 2026-11-19 at 18.10.59 (2).jpeg	1	2026-11-20 04:16:18	2026-11-20 04:16:18
47	9	publications/eBI2ThZpVBvnZsyShQRcC4omarIjLp0ogDXcMhfd.jpg	WhatsApp Image 2026-11-19 at 18.10.59.jpeg	2	2026-11-20 04:16:18	2026-11-20 04:16:18
48	9	publications/2mAP16ll142jJuWcRY3jNrhJbXOFPYJXT2Fq3OoY.jpg	WhatsApp Image 2026-11-19 at 18.11.00 (1).jpeg	3	2026-11-20 04:16:18	2026-11-20 04:16:18
49	9	publications/K7EjjIaU50PbJE4W2w4AfPk526AIs0HjdVr1Qrj4.jpg	WhatsApp Image 2026-11-19 at 18.11.01.jpeg	4	2026-11-20 04:16:18	2026-11-20 04:16:18
50	9	publications/cboltb0dr9zXpdn8RlvtgfFW9ZWjZCDRTU7U9DAx.jpg	WhatsApp Image 2026-11-19 at 18.10.54 (2).jpeg	5	2026-11-20 04:16:18	2026-11-20 04:16:18
51	9	publications/dwldoKr0ubaVlOVmd42HeulvETrHk4oEjnGCz2Ip.jpg	WhatsApp Image 2026-11-19 at 18.10.55.jpeg	6	2026-11-20 04:16:18	2026-11-20 04:16:18
52	9	publications/o8FUJLr2CBO7M8SJLzboh5vXEf4Ri3VrAVFjKNaY.jpg	WhatsApp Image 2026-11-19 at 18.10.56.jpeg	7	2026-11-20 04:16:18	2026-11-20 04:16:18
53	10	publications/LG9OlOAMz3FyGStQAXOhRucbGiNAwPtGwon1DuF9.jpg	WhatsApp Image 2026-11-19 at 18.11.02 (2).jpeg	0	2026-11-20 04:25:12	2026-11-20 04:25:12
54	10	publications/0NX0u44hULl8xRWOxwEPANgjqxVBQ9sdYmkwgMbA.jpg	WhatsApp Image 2026-11-19 at 18.11.02 (3).jpeg	1	2026-11-20 04:25:12	2026-11-20 04:25:12
55	10	publications/3tN7i1yvurR3DJiFDTVlUcwlVTz1W25orj6tpdw3.jpg	WhatsApp Image 2026-11-19 at 18.11.04 (2).jpeg	2	2026-11-20 04:25:12	2026-11-20 04:25:12
56	10	publications/YARP93uekbYUv4powG7MJEZSx3KQ3BUWEAxfk8pZ.jpg	WhatsApp Image 2026-11-19 at 18.11.04 (3).jpeg	3	2026-11-20 04:25:12	2026-11-20 04:25:12
57	10	publications/yd2mRQg7DmeqDwuQOUUiLwqmjdqntPiIkL9rq90q.jpg	WhatsApp Image 2026-11-19 at 18.11.05.jpeg	4	2026-11-20 04:25:12	2026-11-20 04:25:12
58	10	publications/2ozFDwqULwXsb66Cg8xDYyZxqyMfWaHgRUPv6Zay.jpg	WhatsApp Image 2026-11-19 at 18.10.32 (1).jpeg	5	2026-11-20 04:25:12	2026-11-20 04:25:12
59	11	publications/ZHZqlUvzu9y1mPcjuUu3GLf7n78jAVrY8S7LhRxu.jpg	ganadorfutbol.jpeg	0	2026-11-21 06:40:03	2026-11-21 06:40:03
60	11	publications/LXQJccwSfivEapc4lo1TvhkBdnwVdp4GFv1RmnDA.jpg	segundo lugar.jpeg	1	2026-11-21 06:40:03	2026-11-21 06:40:03
61	11	publications/0zaLA5LjFWNBmwbfn6zlmqOWl18RjZWodNSGBhOV.jpg	Futsal.jpeg	2	2026-11-21 06:40:03	2026-11-21 06:40:03
62	12	publications/IlNVpA1jLbavZywRrUC4Xfhxg0m6ZeWUL41iNWXD.jpg	parridalla .jpeg	0	2026-11-21 06:43:28	2026-11-21 06:43:28
63	12	publications/WNbs39PVpR9kpNInaYi4O0TQxVacqB1NWdISfYmV.jpg	parrillada 2.jpeg	1	2026-11-21 06:43:28	2026-11-21 06:43:28
64	12	publications/hJ9AMk1WXdrnKrLXagf7Z67ZN9XvuDLFaV3E9NKM.jpg	parrillada.jpeg	2	2026-11-21 06:43:28	2026-11-21 06:43:28
\.


--
-- Data for Name: publications; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.publications (id, title, slug, excerpt, content, image_path, status, published_at, created_at, updated_at, authors, category_id, activity_date) FROM stdin;
3	INVESTIGACION APLICADA IoT PARA LA AGROINDUSTRIA EN EL SALVADOR	investigacion-aplicada-iot-para-la-agroindustria-en-el-salvador	La ponencia abordó el potencial del Internet de las Cosas (IoT) para transformar la agroindustria en El Salvador. El Mtro. Omar Otoniel Flores Cortez explicó cómo los sensores, la adquisición de datos, el procesamiento de información y la comunicación con plataformas digitales permiten monitorear fenómenos agrícolas, identificar oportunidades de mejora y generar evidencia para la toma de decisiones. Asimismo, destacó las oportunidades de investigación y desarrollo tecnológico que existen para los estudiantes y profesionales de ingeniería.	INVESTIGACIÓN APLICADA EN IoT PARA LA AGROINDUSTRIA EN EL SALVADOR\r\n\r\nPonente: Mtro. Omar Otoniel Flores Cortez\r\n\r\nINTRODUCCIÓN\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, desarrollada en la Facultad Multidisciplinaria Oriental de la Universidad de El Salvador, se presentó la ponencia «Investigación aplicada en IoT para la agroindustria en El Salvador», impartida por el Mtro. Omar Otoniel Flores Cortez.\r\n\r\nLa exposición estuvo enfocada en comprender cómo el Internet de las Cosas (IoT) puede convertirse en una herramienta para investigar fenómenos del entorno, recopilar datos y desarrollar soluciones tecnológicas aplicadas a las necesidades del sector agrícola salvadoreño.\r\n\r\nA lo largo de la ponencia se destacó que existe una importante oportunidad para la investigación académica, especialmente en el desarrollo de sistemas de monitoreo que permitan transformar las actividades agrícolas mediante el uso de tecnologías inteligentes.\r\n\r\n1. ¿QUÉ ES REALMENTE EL INTERNET DE LAS COSAS?\r\n\r\nEl Internet de las Cosas, conocido como IoT por sus siglas en inglés (Internet of Things), es un concepto que hace referencia a la conexión de objetos y dispositivos físicos capaces de recopilar y transmitir información a través de Internet.\r\n\r\nDurante la exposición se estableció una comparación entre el Internet de las personas y el Internet de las cosas. Mientras que plataformas como Facebook permiten compartir información y establecer comunicación entre personas, el IoT permite que sean los propios dispositivos y objetos físicos los que generen y envíen información para que posteriormente pueda ser consultada y utilizada por las personas.\r\n\r\nDesde una perspectiva técnica, estos sistemas están constituidos por dispositivos eléctricos, electrónicos e informáticos con capacidad para obtener información del entorno y transmitirla para su procesamiento.\r\n\r\n2. LA BRECHA TECNOLÓGICA EN LA AGRICULTURA SALVADOREÑA\r\n\r\nUno de los puntos más relevantes de la ponencia fue la identificación de oportunidades tecnológicas dentro del sector agrícola de El Salvador.\r\n\r\nEl expositor mencionó un estudio relacionado con el uso de tecnología en el sector agrícola, según el cual aproximadamente el 85 % de los agricultores salvadoreños necesita datos para apoyar la toma de decisiones en sus actividades productivas.\r\n\r\nEsta situación evidencia la importancia de desarrollar herramientas que permitan recopilar información de manera continua y confiable.\r\n\r\nMuchas decisiones relacionadas con la alimentación del ganado, la crianza de pollos, la producción de tilapias, la fertilización y el manejo de cultivos se realizan principalmente a partir de la experiencia de los productores.\r\n\r\nAunque el conocimiento empírico tiene un valor importante, el uso de información obtenida mediante sensores puede complementar esa experiencia y facilitar decisiones mejor fundamentadas.\r\n\r\n3. PRINCIPALES PROBLEMAS Y OPORTUNIDADES DE INVESTIGACIÓN\r\n\r\nDurante la ponencia se identificaron diferentes dificultades que representan oportunidades para desarrollar proyectos de investigación aplicada.\r\n\r\nMonitoreo discontinuo: la falta de mediciones constantes provoca que los productores no siempre dispongan de información actualizada sobre las condiciones de sus cultivos y actividades productivas.\r\n\r\nCostos elevados: algunos equipos especializados provenientes de países como España, Alemania o Japón pueden representar inversiones de miles de dólares, dificultando su adquisición e implementación.\r\n\r\nAdaptación tecnológica: los equipos desarrollados para otros países pueden presentar inconvenientes cuando se utilizan en condiciones diferentes de infraestructura eléctrica y telecomunicaciones.\r\n\r\nVariabilidad del suelo: conocer cómo cambian las características del suelo y la distribución de sus nutrientes permite identificar oportunidades para optimizar la fertilización, reducir gastos y aprovechar mejor los recursos.\r\n\r\nEstas situaciones demuestran que existe una necesidad de desarrollar tecnologías accesibles y adaptadas a las condiciones particulares de El Salvador.\r\n\r\n4. LA INTEGRACIÓN DE ELECTRÓNICA E INFORMÁTICA\r\n\r\nOtro aspecto fundamental de la exposición fue la importancia de integrar diferentes áreas de la ingeniería para desarrollar soluciones basadas en IoT.\r\n\r\nEl ponente explicó que los profesionales de electricidad y electrónica pueden encargarse de desarrollar dispositivos capaces de medir fenómenos físicos y proporcionar datos, mientras que los profesionales de informática pueden utilizar esos datos para analizarlos mediante diferentes herramientas y desarrollar soluciones tecnológicas.\r\n\r\nEsta colaboración permite construir sistemas que integran sensores, dispositivos electrónicos, adquisición de datos, procesamiento de señales, redes de comunicación, almacenamiento en la nube y aplicaciones informáticas.\r\n\r\nLa integración de estas disciplinas permite convertir una medición física en información digital que puede ser interpretada y utilizada para resolver problemas reales.\r\n\r\n5. DEL FENÓMENO FÍSICO HASTA LA NUBE\r\n\r\nUno de los conceptos centrales de la ponencia fue comprender el recorrido que sigue la información dentro de un sistema IoT.\r\n\r\nEl proceso comienza con la identificación de un fenómeno que se desea estudiar. Posteriormente, se determinan las variables necesarias y se seleccionan los sensores adecuados para realizar las mediciones.\r\n\r\nLos sensores obtienen señales del entorno, las cuales pueden necesitar acondicionamiento electrónico y conversión de señales analógicas a digitales para que los procesadores puedan interpretarlas.\r\n\r\nUna vez obtenidos los datos digitales, estos pasan por diferentes etapas de procesamiento y comunicación hasta llegar a plataformas digitales o servicios en la nube.\r\n\r\nEn estas plataformas, la información puede almacenarse, analizarse y presentarse mediante aplicaciones informáticas.\r\n\r\nDe esta manera, un fenómeno que inicialmente ocurre en el mundo físico puede convertirse en información útil para las personas.\r\n\r\n6. ARQUITECTURA DE OBSERVACIÓN DE LOS SISTEMAS IoT\r\n\r\nDurante la exposición se presentó una arquitectura de observación organizada en cinco capas, que permite comprender cómo funcionan los sistemas de monitoreo basados en Internet de las Cosas.\r\n\r\nPrimera capa: percepción.\r\n\r\nEs la encargada de interactuar directamente con el entorno. En esta etapa se utilizan sensores y dispositivos para medir fenómenos físicos como temperatura, humedad, presencia de personas y otras variables.\r\n\r\nSegunda capa: procesamiento o nodo.\r\n\r\nSe encarga de recibir las lecturas de los sensores y realizar el procesamiento necesario para convertirlas en información que pueda utilizar el sistema.\r\n\r\nTercera capa: red.\r\n\r\nPermite transmitir la información obtenida desde los dispositivos hacia otras partes del sistema mediante tecnologías de comunicación.\r\n\r\nCuarta capa: plataforma.\r\n\r\nEs donde se administran los servicios y se almacenan los datos recopilados, permitiendo su posterior procesamiento y consulta.\r\n\r\nQuinta capa: aplicación.\r\n\r\nEs la interfaz mediante la cual los usuarios pueden visualizar los resultados, consultar información y recibir notificaciones o alertas en tiempo real.\r\n\r\nLa integración de estas cinco capas permite desarrollar sistemas capaces de observar los cambios del entorno y comunicar información relevante a los usuarios.\r\n\r\n7. APLICACIONES DEL IoT EN LA AGROINDUSTRIA\r\n\r\nLa ponencia presentó diferentes oportunidades para aplicar estas tecnologías en actividades agrícolas y productivas.\r\n\r\nEntre los ejemplos mencionados se encuentra el estudio de las condiciones del suelo y la distribución de sus nutrientes, información que puede contribuir a mejorar los procesos de fertilización.\r\n\r\nTambién se destacó la posibilidad de utilizar fotografías de hojas de café para identificar tempranamente posibles problemas en los cultivos.\r\n\r\nEstas aplicaciones permiten comprender que la investigación aplicada puede comenzar con el estudio de fenómenos muy específicos y evolucionar hacia sistemas tecnológicos completos de monitoreo y análisis.\r\n\r\nEl objetivo es desarrollar herramientas que permitan obtener información confiable para apoyar las decisiones de los productores.\r\n\r\n8. SISTEMAS DE MONITOREO Y ALERTAS EN TIEMPO REAL\r\n\r\nOtro aspecto importante fue la evolución de los sistemas de observación y monitoreo.\r\n\r\nActualmente, los sistemas IoT pueden diseñarse para que los usuarios reciban información directamente en sus teléfonos mediante aplicaciones digitales.\r\n\r\nEl expositor utilizó como ejemplo un posible sistema de monitoreo de asistencia dentro de un auditorio, en el que los administradores pudieran conocer en tiempo real cuántas personas se encuentran dentro de las instalaciones.\r\n\r\nEste tipo de solución también podría proporcionar información útil en situaciones de emergencia, como un incendio, cuando resulta importante conocer la cantidad de personas presentes.\r\n\r\nEl ejemplo demuestra que el IoT no se limita a la agricultura, sino que también puede aplicarse a la seguridad, la administración de espacios y otros entornos.\r\n\r\n9. INVESTIGACIÓN APLICADA Y OPORTUNIDADES PARA LOS ESTUDIANTES\r\n\r\nLa exposición también hizo énfasis en la oportunidad que representa la brecha tecnológica para quienes forman parte de la academia y de los procesos de investigación.\r\n\r\nEl desarrollo de soluciones IoT abre posibilidades para proponer tesis de grado, investigaciones de maestría y proyectos tecnológicos orientados a resolver problemas existentes en el país.\r\n\r\nPara los estudiantes de Ingeniería de Sistemas Informáticos, estas oportunidades permiten aplicar conocimientos de programación, bases de datos, redes, procesamiento de información y desarrollo de aplicaciones.\r\n\r\nLa investigación aplicada permite pasar de los conocimientos teóricos a la construcción de herramientas funcionales que respondan a necesidades concretas de la sociedad.\r\n\r\n10. EL CICLO DE GENERACIÓN DE INFORMACIÓN Y TOMA DE DECISIONES\r\n\r\nUna de las ideas más importantes de la ponencia fue que un sistema IoT no debe limitarse a recopilar datos.\r\n\r\nEl verdadero valor se encuentra en transformar esos datos en información que sirva como evidencia para tomar decisiones.\r\n\r\nEste proceso puede resumirse en las siguientes etapas:\r\n\r\n1. Identificación del fenómeno que se desea estudiar.\r\n2. Selección de las variables que deben medirse.\r\n3. Captura de información mediante sensores.\r\n4. Procesamiento de las lecturas.\r\n5. Transmisión de datos hacia plataformas digitales.\r\n6. Almacenamiento y análisis de la información.\r\n7. Presentación de resultados al usuario.\r\n8. Toma de decisiones basadas en la evidencia obtenida.\r\n9. Seguimiento de los cambios producidos en el fenómeno.\r\n\r\nEste ciclo debe mantenerse en constante actualización para que el sistema continúe proporcionando información útil sobre el entorno observado.\r\n\r\nCONCLUSIÓN\r\n\r\nLa ponencia «Investigación aplicada en IoT para la agroindustria en El Salvador» permitió conocer las oportunidades que ofrece el Internet de las Cosas para impulsar la innovación y fortalecer los procesos de investigación en el país.\r\n\r\nUno de los principales aprendizajes fue comprender que detrás de cada sistema inteligente existe un proceso que comienza con la observación de un fenómeno, continúa con la adquisición y procesamiento de datos y finaliza con la generación de información que permite tomar decisiones.\r\n\r\nAsimismo, se destacó la importancia de la colaboración entre las áreas de electrónica, electricidad e informática para desarrollar soluciones tecnológicas adaptadas a las necesidades del entorno salvadoreño.\r\n\r\nPara los estudiantes universitarios, esta ponencia representa una invitación a investigar, experimentar y proponer proyectos que permitan utilizar la tecnología como una herramienta para resolver problemas reales.\r\n\r\nEl Internet de las Cosas no solamente conecta dispositivos: permite conectar los fenómenos del mundo real con la investigación, el conocimiento y la toma de decisiones.\r\n\r\nSEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nUniversidad de El Salvador\r\nFacultad Multidisciplinaria Oriental	\N	published	2026-11-16 10:00:00	2026-11-17 20:18:04	2026-11-20 00:08:31	Mtro.Omar ztoniel Flores Cortes	1	2026-11-16
4	EFICIENCIA ENERGÉTICA Y ENERGÍAS RENOVABLES	eficiencia-energetica-y-energias-renovables	La ponencia abordó la importancia de la eficiencia energética y el aprovechamiento de las energías renovables mediante tecnologías inteligentes. Se explicó cómo el Internet de las Cosas permite medir, recopilar y gestionar información relacionada con el consumo energético, utilizando ejemplos como los sistemas de climatización, los dispositivos conectados y la generación de energía a partir del movimiento humano. Asimismo, se destacó la importancia de utilizar los datos para optimizar recursos y desarrollar soluciones tecnológicas sostenibles.	EFICIENCIA ENERGÉTICA Y ENERGÍAS RENOVABLES\r\n\r\nINTRODUCCIÓN\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, se desarrolló una ponencia relacionada con la eficiencia energética y las energías renovables. Durante la exposición se abordó la importancia de comprender cómo utilizamos la energía, cómo podemos medir su consumo y de qué manera las tecnologías actuales permiten obtener información para mejorar su gestión.\r\n\r\nEl expositor relacionó la ingeniería eléctrica con la ingeniería en ciencias de la computación, destacando que ambas áreas pueden trabajar conjuntamente para desarrollar soluciones tecnológicas mediante el Internet de las Cosas.\r\n\r\n1. EL CONSUMO ENERGÉTICO Y LOS SISTEMAS DE CLIMATIZACIÓN\r\n\r\nUno de los primeros ejemplos presentados estuvo relacionado con las diferencias de temperatura entre el ambiente exterior y los espacios interiores.\r\n\r\nEl expositor invitó a los asistentes a reflexionar sobre la sensación térmica que experimentamos al encontrarnos fuera de un edificio y compararla con la temperatura que sentimos al ingresar a un espacio climatizado.\r\n\r\nA partir de esta situación, hizo referencia al funcionamiento de los equipos de aire acondicionado y a las temperaturas a las que suelen configurarse.\r\n\r\nTambién destacó que las máquinas de climatización de espacios, especialmente los aires acondicionados, representan uno de los equipos que más energía consumen dentro de las instalaciones y los edificios.\r\n\r\nEste ejemplo permitió reflexionar sobre la manera en que utilizamos la electricidad y la importancia de prestar atención al consumo energético de los sistemas de climatización.\r\n\r\n2. LA IMPORTANCIA DE MEDIR PARA PODER GESTIONAR\r\n\r\nDurante la exposición se destacó una idea fundamental: aquello que no podemos medir tampoco podemos gestionarlo adecuadamente.\r\n\r\nEl expositor relacionó este principio con la necesidad de obtener información sobre el funcionamiento de los equipos y dispositivos que utilizamos diariamente.\r\n\r\nMedir permite conocer lo que está sucediendo, identificar comportamientos y obtener datos que posteriormente pueden utilizarse para mejorar la gestión de los recursos.\r\n\r\nEsta idea también se relaciona con el Internet de las Cosas, ya que mediante dispositivos conectados es posible recopilar información de diferentes elementos del entorno.\r\n\r\n3. LA RELACIÓN ENTRE LA INGENIERÍA ELÉCTRICA Y LA INFORMÁTICA\r\n\r\nOtro de los puntos abordados fue la cercanía que existe entre la ingeniería eléctrica y la ingeniería en ciencias de la computación.\r\n\r\nEl expositor destacó que ambas disciplinas se complementan y pueden trabajar conjuntamente en el desarrollo de soluciones tecnológicas.\r\n\r\nDurante su intervención mencionó que diferentes dispositivos, como los aires acondicionados, teléfonos, microondas y lavadoras, pueden incorporar conectividad mediante direcciones IP.\r\n\r\nEsto permite comprender cómo objetos que tradicionalmente utilizamos para realizar actividades cotidianas pueden formar parte de sistemas conectados.\r\n\r\nLa posibilidad de obtener datos de estos dispositivos representa una oportunidad para desarrollar aplicaciones relacionadas con el monitoreo y la gestión de diferentes recursos.\r\n\r\n4. EL INTERNET DE LAS COSAS EN LOS OBJETOS COTIDIANOS\r\n\r\nEl ponente explicó que el Internet de las Cosas no se limita únicamente a computadoras o teléfonos inteligentes.\r\n\r\nCualquier objeto que incorpore los elementos tecnológicos necesarios puede convertirse en una fuente de información mediante la incorporación de sensores y conectividad.\r\n\r\nPara explicar esta idea, utilizó como ejemplo un par de zapatos y planteó a los asistentes qué variables podrían obtenerse de un objeto de este tipo.\r\n\r\nEntre las respuestas mencionó el peso y la velocidad de desplazamiento de una persona.\r\n\r\nA partir de estas variables, explicó que la información obtenida podría ser útil para un médico ortopeda, permitiéndole observar determinados comportamientos relacionados con el movimiento de una persona y contribuir a la prevención de posibles enfermedades degenerativas.\r\n\r\nEste ejemplo permitió comprender que los objetos cotidianos pueden convertirse en herramientas para recopilar información y generar nuevas posibilidades de aplicación tecnológica.\r\n\r\n5. GENERACIÓN DE ENERGÍA MEDIANTE EL MOVIMIENTO HUMANO\r\n\r\nUno de los ejemplos más interesantes compartidos durante la ponencia fue la posibilidad de generar energía eléctrica mediante el movimiento producido al caminar.\r\n\r\nEl expositor explicó que un mismo par de zapatos puede aprovechar el movimiento de una persona para generar energía eléctrica.\r\n\r\nTambién hizo referencia a cómo esta energía puede representarse mediante una señal eléctrica que posteriormente puede aprovecharse para cargar una batería.\r\n\r\nA partir de esta idea, planteó la posibilidad de utilizar la energía generada al caminar para alimentar dispositivos, incluso un teléfono móvil.\r\n\r\nEste ejemplo permitió reflexionar sobre las diferentes formas en que la tecnología puede aprovechar actividades cotidianas para obtener energía.\r\n\r\n6. EFICIENCIA ENERGÉTICA Y ENERGÍAS RENOVABLES\r\n\r\nEn la parte final de la exposición se abordó la importancia de las energías renovables, mencionando específicamente la energía eólica y la hidroeléctrica.\r\n\r\nEstas fuentes representan alternativas para la generación de electricidad mediante el aprovechamiento de recursos naturales.\r\n\r\nLa exposición permitió relacionar el uso responsable de la energía con la necesidad de conocer las diferentes alternativas disponibles para su generación y aprovechamiento.\r\n\r\nAsimismo, se destacó la importancia de integrar los conocimientos tecnológicos y de ingeniería para comprender mejor los sistemas energéticos.\r\n\r\nCONCLUSIÓN\r\n\r\nLa ponencia permitió reflexionar sobre la importancia de la eficiencia energética y el papel que desempeña la tecnología en la medición y gestión de los recursos.\r\n\r\nA través de ejemplos relacionados con los aires acondicionados, los dispositivos conectados y la generación de energía mediante el movimiento humano, el expositor mostró cómo el Internet de las Cosas puede aplicarse en situaciones de la vida cotidiana.\r\n\r\nTambién resaltó la relación entre la ingeniería eléctrica y la informática, demostrando que ambas disciplinas pueden complementarse para desarrollar nuevas soluciones tecnológicas.\r\n\r\nLa exposición dejó como enseñanza la importancia de observar nuestro entorno, identificar qué podemos medir y aprovechar la tecnología para comprender y gestionar mejor los recursos que utilizamos.\r\n\r\nSEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nUniversidad de El Salvador\r\nFacultad Multidisciplinaria Oriental	\N	published	2026-11-19 03:00:00	2026-11-20 00:55:33	2026-11-20 00:55:33	Dr.Carlos Osmin Pocasangre Jimenez	1	2026-11-16
5	EFICIENCIA ENERGÉTICA, OPTIMIZACIÓN DE RECURSOS Y SOSTENIBILIDAD APLICADA A SOLUCIONES TECNOLÓGICAS	eficiencia-energetica-optimizacion-de-recursos-y-sostenibilidad-aplicada-a-soluciones-tecnologicas	La ponencia impartida por el Lic. Nahum Alexander Sánchez Cruz abordó la automatización de sistemas de aire acondicionado mediante el Internet de las Cosas (IoT), BACnet e Inteligencia Artificial. Se presentó la importancia de optimizar el consumo energético en edificios y oficinas, así como la integración de sensores, actuadores, sistemas de comunicación y procesamiento mediante API en .NET para desarrollar soluciones tecnológicas orientadas a la eficiencia energética y la sostenibilidad.	EFICIENCIA ENERGÉTICA, OPTIMIZACIÓN DE RECURSOS Y SOSTENIBILIDAD APLICADA A SOLUCIONES TECNOLÓGICAS\r\n\r\nPonente: Lic. Nahum Alexander Sánchez Cruz\r\n\r\nINTRODUCCIÓN\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, realizada en la Facultad Multidisciplinaria Oriental de la Universidad de El Salvador, se desarrolló la ponencia titulada «Eficiencia energética, optimización de recursos y sostenibilidad aplicada a soluciones tecnológicas», impartida por el Lic. Nahum Alexander Sánchez Cruz.\r\n\r\nLa exposición abordó la automatización de sistemas de aire acondicionado mediante el Internet de las Cosas (IoT), BACnet e Inteligencia Artificial (IA), mostrando cómo la integración de diferentes tecnologías permite desarrollar soluciones orientadas al control de equipos, la optimización de recursos y la eficiencia energética.\r\n\r\n1. EL CONSUMO ENERGÉTICO EN EDIFICIOS Y OFICINAS\r\n\r\nDurante la exposición, el ponente planteó una pregunta para reflexionar sobre el consumo innecesario de electricidad:\r\n\r\n¿Cuántos aires acondicionados quedan encendidos esta noche en oficinas vacías en tu ciudad?\r\n\r\nEsta interrogante permitió identificar una situación que puede presentarse diariamente en edificios y espacios de trabajo: equipos de climatización que permanecen encendidos incluso cuando las oficinas se encuentran vacías.\r\n\r\nEste escenario evidencia la importancia de implementar mecanismos tecnológicos que permitan supervisar y controlar el funcionamiento de los equipos, evitando consumos innecesarios y aprovechando mejor los recursos energéticos.\r\n\r\n2. EFICIENCIA ENERGÉTICA, OPTIMIZACIÓN DE RECURSOS Y SOSTENIBILIDAD\r\n\r\nUno de los ejes centrales de la ponencia fue la relación entre eficiencia energética, optimización de recursos y sostenibilidad.\r\n\r\nLa presentación destacó la necesidad de aplicar soluciones tecnológicas que permitan mejorar el funcionamiento de los sistemas de climatización y aprovechar de manera más adecuada la energía utilizada en edificios y oficinas.\r\n\r\nLa automatización representa una oportunidad para supervisar los equipos y facilitar su administración mediante sistemas conectados.\r\n\r\n3. AUTOMATIZACIÓN DE AIRES ACONDICIONADOS MEDIANTE IoT, BACnet E IA\r\n\r\nLa exposición presentó como tema principal la automatización de sistemas de aire acondicionado mediante tres elementos tecnológicos: Internet de las Cosas, BACnet e Inteligencia Artificial.\r\n\r\nEstas tecnologías forman parte de una propuesta de integración que permite conectar los equipos físicos con sistemas informáticos para facilitar su supervisión y control.\r\n\r\nLa finalidad es establecer una comunicación entre los dispositivos de climatización y las plataformas encargadas de procesar la información, permitiendo administrar los equipos mediante soluciones tecnológicas.\r\n\r\n4. LAS CUATRO CAPAS IoT: DEL EQUIPO FÍSICO AL PANEL\r\n\r\nUna de las diapositivas más importantes de la exposición presentó el funcionamiento de la comunicación entre los equipos físicos y las plataformas informáticas mediante una arquitectura de cuatro capas IoT.\r\n\r\nPrimera capa: Percepción.\r\n\r\nEn esta etapa se encuentran las unidades VRF, junto con los sensores y actuadores. Estos elementos forman parte del sistema físico de climatización y permiten obtener información e intervenir en el funcionamiento de los equipos.\r\n\r\nSegunda capa: Comunicación.\r\n\r\nEn esta etapa se utiliza un Gateway BACnet conectado a la red local de la empresa. Su función dentro de la arquitectura es permitir la comunicación entre los equipos físicos y los sistemas informáticos.\r\n\r\nTercera capa: Procesamiento.\r\n\r\nLa presentación mostró una API desarrollada en .NET, encargada de leer y cambiar valores. Esta parte permite que la información obtenida de los dispositivos pueda ser procesada y que se puedan realizar acciones sobre los sistemas conectados.\r\n\r\nCuarta capa: Visualización y panel de control.\r\n\r\nLa diapositiva muestra el paso de los equipos físicos hacia un panel. Esta etapa representa la presentación de la información y la interacción con el sistema desde una interfaz de supervisión.\r\n\r\nLa integración de estas capas permite comprender cómo se conectan los equipos de climatización con las herramientas informáticas utilizadas para su administración.\r\n\r\n5. EL PAPEL DE BACnet EN LA AUTOMATIZACIÓN\r\n\r\nBACnet fue uno de los elementos tecnológicos destacados durante la presentación.\r\n\r\nSu presencia en la arquitectura demuestra la importancia de establecer mecanismos de comunicación entre los equipos de climatización y los sistemas encargados de administrarlos.\r\n\r\nMediante el Gateway BACnet y la red local de la empresa, los dispositivos pueden integrarse a una infraestructura tecnológica que facilita la supervisión y el intercambio de información.\r\n\r\n6. PROCESAMIENTO DE INFORMACIÓN MEDIANTE API EN .NET\r\n\r\nOtro elemento presentado fue el procesamiento mediante una API en .NET.\r\n\r\nLa diapositiva identificó dos funciones principales: leer valores y cambiar valores.\r\n\r\nEsto permite relacionar los equipos físicos con el desarrollo de software, demostrando cómo una aplicación informática puede comunicarse con los dispositivos de un sistema de climatización.\r\n\r\nLa utilización de herramientas de desarrollo como .NET evidencia la participación de la Ingeniería de Sistemas Informáticos en la creación de soluciones para la automatización de edificios.\r\n\r\n7. IMPORTANCIA DE LA AUTOMATIZACIÓN Y LA SOSTENIBILIDAD\r\n\r\nLa ponencia permitió reflexionar sobre la importancia de implementar tecnologías que faciliten el control de los recursos energéticos.\r\n\r\nLa automatización de los sistemas de aire acondicionado representa una aplicación del IoT orientada a mejorar la administración de los equipos y evitar que permanezcan funcionando innecesariamente.\r\n\r\nLa integración de sensores, actuadores, comunicación BACnet y procesamiento mediante API permite comprender cómo diferentes componentes pueden trabajar conjuntamente dentro de una solución tecnológica.\r\n\r\nCONCLUSIÓN\r\n\r\nLa ponencia impartida por el Lic. Nahum Alexander Sánchez Cruz permitió conocer una aplicación del Internet de las Cosas enfocada en la eficiencia energética y la automatización de sistemas de climatización.\r\n\r\nUno de los aspectos más importantes fue comprender cómo se establece la comunicación entre los equipos físicos, los dispositivos de conexión y las aplicaciones informáticas mediante una arquitectura de cuatro capas IoT.\r\n\r\nAsimismo, la presentación destacó la participación de tecnologías como BACnet y .NET en el desarrollo de soluciones que permiten leer y modificar valores de los equipos conectados.\r\n\r\nPara los estudiantes de Ingeniería de Sistemas Informáticos, esta experiencia permite reconocer nuevas oportunidades de aplicación de los conocimientos informáticos en áreas como la automatización, la conectividad y la gestión inteligente de edificios.\r\n\r\nLa tecnología puede convertirse en una herramienta fundamental para optimizar recursos y construir espacios más eficientes y sostenibles.\r\n\r\nSEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nUniversidad de El Salvador\r\nFacultad Multidisciplinaria Oriental	\N	published	2026-11-17 08:00:00	2026-11-20 01:31:42	2026-11-20 01:32:19	Lic. Nahum Alexander Sánchez Cruz	1	2026-11-17
6	CIBERSEGURIDAD, INTELIGENCIA ARTIFICIAL Y GESTIÓN DEL RIESGO EN LAS ORGANIZACIONES	ciberseguridad-inteligencia-artificial-y-gestion-del-riesgo-en-las-organizaciones	La cuarta ponencia de la Semana de Sistemas SDS26 GREEN IoT abordó la importancia de la ciberseguridad, haciendo énfasis en la identificación de correos electrónicos maliciosos y ataques de phishing. Durante la actividad se explicaron los riesgos de los m	CIBERSEGURIDAD: IDENTIFICACIÓN DE CORREOS MALICIOSOS, PHISHING Y PREVENCIÓN DE ATAQUES INFORMÁTICOS\r\n\r\nPonentes: Victoria Rivas y Edwin Umaña.\r\n\r\nActividad: Semana de Sistemas SDS26 GREEN IoT.\r\n\r\nINTRODUCCIÓN\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, se desarrolló la cuarta ponencia con la participación de Victoria Rivas y Edwin Umaña, quienes compartieron conocimientos relacionados con la ciberseguridad, la inteligencia artificial y los riesgos presentes en el entorno digital.\r\n\r\nDurante esta actividad se hizo especial énfasis en los correos electrónicos maliciosos, las técnicas de phishing y la importancia de aprender a identificar posibles amenazas antes de interactuar con ellas.\r\n\r\nLa ponencia combinó explicaciones con una dinámica práctica que permitió involucrar a los estudiantes y demostrar que la seguridad informática también depende de la capacidad de los usuarios para reconocer situaciones sospechosas.\r\n\r\n1. EL PHISHING Y LOS CORREOS ELECTRÓNICOS MALICIOSOS\r\n\r\nUno de los temas abordados fue el phishing, una técnica utilizada por ciberdelincuentes para engañar a las personas mediante mensajes y correos electrónicos fraudulentos.\r\n\r\nEste tipo de amenazas busca que los usuarios realicen acciones que pueden comprometer su seguridad, como abrir enlaces sospechosos, descargar archivos maliciosos o proporcionar información confidencial.\r\n\r\nDurante la exposición se destacó la importancia de prestar atención a los mensajes recibidos, especialmente cuando contienen enlaces desconocidos, solicitudes de información personal o comunicaciones que generan urgencia para que el usuario actúe sin verificar su autenticidad.\r\n\r\n2. APRENDER A IDENTIFICAR UN CORREO FRAUDULENTO\r\n\r\nLa ponencia no se limitó a explicar los conceptos de ciberseguridad, sino que también permitió observar cómo se pueden identificar posibles amenazas en situaciones reales.\r\n\r\nSe destacó la necesidad de analizar cuidadosamente los correos electrónicos antes de abrir sus enlaces o descargar sus archivos adjuntos.\r\n\r\nReconocer un correo sospechoso es una habilidad importante para cualquier usuario, especialmente para quienes trabajan o estudian en entornos donde se maneja información digital.\r\n\r\n3. UNA EXPERIENCIA PRÁCTICA CON LOS ESTUDIANTES\r\n\r\nUno de los momentos más interesantes de la actividad fue la participación del futuro ingeniero Quevedo, quien fue invitado por el ponente a realizar un ejercicio práctico.\r\n\r\nDurante esta dinámica se le presentó el desafío de analizar un correo electrónico y determinar si se trataba de un mensaje legítimo o de un intento de phishing.\r\n\r\nEsta participación permitió trasladar los conocimientos teóricos a una situación práctica, demostrando la importancia de desarrollar habilidades para reconocer correos fraudulentos.\r\n\r\nLa experiencia también motivó la participación de los asistentes, quienes pudieron observar cómo se realiza el análisis de un mensaje antes de confiar en su contenido.\r\n\r\n4. LA IMPORTANCIA DE REACCIONAR ANTE UN INCIDENTE DE SEGURIDAD\r\n\r\nDurante la exposición se presentaron recomendaciones sobre cómo actuar cuando una persona identifica una posible amenaza informática.\r\n\r\nEntre las indicaciones compartidas se encontraron:\r\n\r\nDesconectar: Si se ha ejecutado un archivo sospechoso, desconectar el equipo de la red y evitar realizar acciones que puedan agravar la situación.\r\n\r\nCerrar sesiones: Desde otro dispositivo, cerrar las sesiones abiertas en las cuentas y cambiar las contraseñas correspondientes.\r\n\r\nAvisar: Informar inmediatamente al área de tecnología de la información o a la institución para facilitar la atención del incidente.\r\n\r\nLa exposición destacó que avisar rápidamente es una de las acciones que más ayuda a reducir los daños.\r\n\r\n5. HUMAN RISK MANAGEMENT: EL FACTOR HUMANO EN LA CIBERSEGURIDAD\r\n\r\nOtro tema presentado fue Human Risk Management, relacionado con la gestión de los riesgos asociados al comportamiento humano dentro de las organizaciones.\r\n\r\nSe explicó que la seguridad informática no consiste en buscar culpables cuando ocurre un incidente, sino en comprender los riesgos humanos, reducir los errores involuntarios y fomentar hábitos seguros.\r\n\r\nCada colaborador puede convertirse en una línea de defensa frente a las amenazas digitales.\r\n\r\nEsto demuestra que la protección de la información no depende exclusivamente de los programas y sistemas de seguridad, sino también de la responsabilidad y preparación de las personas que utilizan la tecnología.\r\n\r\n6. LA INTELIGENCIA ARTIFICIAL EN LAS EMPRESAS\r\n\r\nDurante la jornada también se abordaron las aplicaciones de la inteligencia artificial en el entorno empresarial.\r\n\r\nEntre los usos presentados se mencionaron la atención al cliente mediante chatbots, la automatización de tareas repetitivas, la generación de informes, el análisis de datos, la selección de personal y las recomendaciones en ventas y marketing.\r\n\r\nAsimismo, se presentó una reflexión sobre cómo la adopción de la inteligencia artificial avanza más rápido que la gobernanza, destacando la importancia de establecer mecanismos de control y responsabilidad para su utilización.\r\n\r\nCONCLUSIÓN\r\n\r\nLa cuarta ponencia de la Semana de Sistemas SDS26 GREEN IoT permitió comprender que la ciberseguridad es una responsabilidad compartida y que los usuarios desempeñan un papel fundamental en la protección de la información.\r\n\r\nUno de los aprendizajes más importantes fue reconocer los riesgos asociados al phishing y los correos electrónicos maliciosos, así como la necesidad de analizar los mensajes antes de abrir enlaces o descargar archivos.\r\n\r\nLa participación práctica del futuro ingeniero Quevedo hizo que la actividad fuera más dinámica y permitió demostrar la importancia de aplicar los conocimientos adquiridos para identificar posibles amenazas.\r\n\r\nFinalmente, la exposición dejó una enseñanza importante para los futuros profesionales de Ingeniería de Sistemas Informáticos: no basta con conocer las herramientas tecnológicas, también es necesario aprender a utilizarlas de manera segura, responsable y consciente.\r\n\r\nSEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nUniversidad de El Salvador\r\nFacultad Multidisciplinaria Oriental	\N	published	2026-11-19 10:55:00	2026-11-20 02:55:27	2026-11-20 02:55:27	Victoria Rivas, Edwin Umaña	1	2026-11-17
7	SOSTENIBILIDAD Y ANÁLISIS ENERGÉTICO MEDIANTE ELECTRICITY MAPS	sostenibilidad-y-analisis-energetico-mediante-electricity-maps	El taller Sostenibilidad y análisis energético mediante Electricity Maps permitió conocer cómo las herramientas tecnológicas pueden utilizarse para analizar el impacto ambiental del consumo eléctrico. Durante la actividad se realizaron comparaciones de intensidad de carbono entre El Salvador y Guatemala, considerando sus diferentes fuentes de generación energética. Además, se presentó un ejercicio práctico sobre Green IoT, demostrando cómo el uso de sensores para suspender computadoras inactivas puede reducir el consumo eléctrico y contribuir al ahorro de energía. La experiencia permitió relacionar la tecnología, el análisis de datos y la sostenibilidad ambiental.	SOSTENIBILIDAD Y ANÁLISIS ENERGÉTICO MEDIANTE ELECTRICITY MAPS\r\n\r\nTaller desarrollado en la Semana de Sistemas SDS26 GREEN IoT.\r\n\r\nFacilitadores:\r\nBr. Josué González\r\nBr. Erick Espinoza\r\nBr. Edwin Robles\r\nBr. Israel Lara\r\nBr. Jefferson Vásquez\r\n\r\nINTRODUCCIÓN\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, se desarrolló el taller «Sostenibilidad y análisis energético mediante Electricity Maps», una actividad orientada a demostrar cómo la tecnología permite analizar el consumo de energía eléctrica y comprender su impacto ambiental.\r\n\r\nDurante el taller se abordaron temas relacionados con la huella de carbono, la intensidad de carbono de la electricidad y la utilización de herramientas digitales para comparar el comportamiento energético de diferentes regiones.\r\n\r\nAsimismo, se presentaron ejemplos prácticos de cómo aplicar los principios de Green IoT para reducir el consumo eléctrico mediante soluciones tecnológicas.\r\n\r\n1. COMPARACIÓN DE ZONAS Y HORAS MEDIANTE ELECTRICITY MAPS\r\n\r\nUno de los ejercicios presentados consistió en comparar la intensidad de carbono de la electricidad entre diferentes países.\r\n\r\nEn la presentación se mostraron los siguientes datos:\r\n\r\nEl Salvador:\r\nIntensidad de carbono: 160 g/kWh.\r\nDato destacado: participación solar del 38 %.\r\n\r\nGuatemala:\r\nIntensidad de carbono: 410 g/kWh.\r\nDato destacado: participación hidroeléctrica del 39 %.\r\n\r\nEsta comparación permitió observar que el impacto ambiental asociado al consumo eléctrico puede variar dependiendo del país, la hora y las fuentes utilizadas para generar electricidad.\r\n\r\nTambién se presentó un ejemplo de una misma tarea con un consumo de 0.50 kWh, cuyo impacto estimado era de 80 gramos frente a 205 gramos de emisiones de carbono, según la intensidad energética de cada zona.\r\n\r\nDe esta manera, los participantes pudieron comprender que consumir la misma cantidad de electricidad no necesariamente representa el mismo impacto ambiental en todos los lugares.\r\n\r\n2. DEMANDA, MEZCLA ENERGÉTICA Y FLUJOS ELÉCTRICOS\r\n\r\nDurante la exposición también se explicaron tres aspectos importantes para interpretar la información energética:\r\n\r\nDemanda: representa la potencia que requiere una red eléctrica para abastecer el consumo de sus usuarios.\r\n\r\nMezcla energética: permite identificar las diferentes fuentes que participan en la generación de electricidad y conocer su contribución.\r\n\r\nFlujos eléctricos: permiten observar qué redes reciben o envían electricidad, de acuerdo con la información representada en la plataforma.\r\n\r\nEstos elementos ayudan a comprender cómo se comporta el sistema eléctrico y por qué es importante analizar tanto el consumo como el origen de la energía utilizada.\r\n\r\n3. GREEN IoT EN ACCIÓN: UN CAMBIO MEDIBLE\r\n\r\nOtro de los momentos importantes del taller fue la presentación de un ejemplo práctico titulado «Un cambio Green IoT medible».\r\n\r\nEn este ejercicio se utilizaron cuatro computadoras inactivas durante una hora para comparar dos situaciones: mantenerlas en espera o implementar un sistema de suspensión mediante sensores.\r\n\r\nEn el primer escenario, las cuatro computadoras permanecían en espera, con un consumo conjunto de 200 W y un gasto energético de 0.200 kWh durante una hora.\r\n\r\nEn el segundo escenario, se implementó la suspensión mediante sensores, reduciendo el consumo de las computadoras y considerando también el consumo del sensor y la pasarela de comunicación. El consumo total pasó a 28 W, equivalente a 0.028 kWh durante esa hora.\r\n\r\nLa comparación presentada mostró un ahorro estimado de 0.172 kWh en una hora.\r\n\r\nEste ejemplo permitió demostrar que pequeñas modificaciones en la administración de los equipos tecnológicos pueden generar ahorros energéticos medibles.\r\n\r\n4. USAR MENOS ENERGÍA MEDIANTE SOLUCIONES INTELIGENTES\r\n\r\nLa actividad destacó la importancia de implementar medidas para evitar el consumo innecesario de electricidad.\r\n\r\nEntre las propuestas presentadas se encuentran suspender los equipos que permanecen inactivos y utilizar sensores para automatizar esta tarea.\r\n\r\nTambién se destacó la importancia de verificar los resultados mediante mediciones del consumo eléctrico en ambas pruebas y comprobar que las computadoras puedan reanudar sus actividades correctamente.\r\n\r\nEsto demuestra cómo la incorporación de sensores y sistemas de automatización puede contribuir a una administración más eficiente de los recursos tecnológicos.\r\n\r\n5. REDES DE MENOR INTENSIDAD DE CARBONO\r\n\r\nOtro aspecto abordado fue la posibilidad de trasladar determinadas actividades o cargas flexibles hacia horarios o zonas donde la electricidad presente una menor intensidad de carbono.\r\n\r\nLa idea consiste en aprovechar momentos en los que la generación eléctrica tenga un menor impacto ambiental, siempre que las condiciones de funcionamiento lo permitan.\r\n\r\nEsta propuesta relaciona el análisis energético con la toma de decisiones tecnológicas, mostrando que no solamente importa cuánta electricidad se consume, sino también cuándo y dónde se utiliza.\r\n\r\n6. LA IMPORTANCIA DEL INTERNET DE LAS COSAS PARA LA SOSTENIBILIDAD\r\n\r\nEl taller permitió observar cómo el Internet de las Cosas puede aplicarse a la sostenibilidad mediante sensores, dispositivos conectados y sistemas capaces de automatizar determinadas actividades.\r\n\r\nLa utilización de estos recursos permite supervisar el funcionamiento de los equipos y tomar decisiones para reducir consumos innecesarios.\r\n\r\nEl ejemplo de las computadoras inactivas demostró que la integración de sensores puede convertirse en una alternativa para mejorar la eficiencia energética en espacios de trabajo, instituciones educativas y organizaciones.\r\n\r\nCONCLUSIÓN\r\n\r\nEl taller «Sostenibilidad y análisis energético mediante Electricity Maps» permitió comprender la relación entre tecnología, consumo eléctrico y protección ambiental.\r\n\r\nUno de los aprendizajes más importantes fue reconocer que la electricidad puede tener diferentes impactos ambientales dependiendo de las fuentes utilizadas para su generación y de las condiciones de cada región.\r\n\r\nAsimismo, el ejercicio de Green IoT demostró que la implementación de sensores y mecanismos de automatización puede producir ahorros energéticos medibles, incluso mediante acciones aparentemente pequeñas, como suspender computadoras que permanecen inactivas.\r\n\r\nEsta experiencia permitió a los participantes reconocer que la Ingeniería de Sistemas Informáticos también puede contribuir a la sostenibilidad mediante el desarrollo e implementación de soluciones inteligentes.\r\n\r\nLa tecnología no solamente debe orientarse a facilitar nuestras actividades, sino también a utilizar responsablemente los recursos y contribuir a reducir el impacto ambiental.\r\n\r\nSEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nUniversidad de El Salvador\r\nFacultad Multidisciplinaria Oriental	\N	published	2026-11-19 13:28:00	2026-11-20 03:28:58	2026-11-20 03:28:58	Br. Josué González	2	2026-11-17
1	INAURACION DE LA SEMANA SISTEMA IOT	inauracion-de-la-semana-sistema-iot	Damos inicio a la Semana de Sistemas 2026, un espacio dedicado a la innovación tecnológica, el aprendizaje y el intercambio de conocimientos sobre el Internet de las Cosas (IoT).	Inauguración de la Semana de Sistemas IoT 2026\r\n\r\nLa carrera de Ingeniería de Sistemas Informáticos da inicio a la Semana de Sistemas 2026, un espacio académico y tecnológico orientado a promover el conocimiento, la innovación y la investigación aplicada.\r\n\r\nDurante esta jornada se desarrollarán diferentes actividades enfocadas en el Internet de las Cosas (IoT), una tecnología que permite conectar dispositivos y sistemas para recopilar, intercambiar y analizar información en tiempo real.\r\n\r\nEsta celebración representa una oportunidad para que estudiantes, docentes e invitados compartan experiencias, conocimientos y proyectos relacionados con las nuevas tendencias tecnológicas.\r\n\r\n¡Bienvenidos a la Semana de Sistemas 2026! Un espacio para aprender, innovar y construir el futuro de la tecnología.	\N	published	2026-11-16 08:00:00	2026-11-17 15:22:46	2026-11-20 04:29:09	Comité organizador SDS26 GREEN IoT	8	2026-11-16
8	Gran Bingo – Semana de Sistemas SDS26 GREEN IoT	gran-bingo-semana-de-sistemas-sds26-green-iot	Durante la Semana de Sistemas SDS26 GREEN IoT se desarrolló el Gran Bingo, una actividad recreativa que combinó entretenimiento, innovación tecnológica y convivencia universitaria. Mediante una plataforma web, los participantes pudieron adquirir sus cartones por $1.00, ingresar a una sala mediante un código QR y seguir en tiempo real el sorteo de los números.	GRAN BINGO DIGITAL – SEMANA DE SISTEMAS SDS26 GREEN IoT\r\n\r\nEn el marco de la Semana de Sistemas SDS26 GREEN IoT, el miércoles 18 de noviembre se llevó a cabo el Gran Bingo, una actividad recreativa que combinó entretenimiento, innovación tecnológica y convivencia universitaria.\r\n\r\nUna de las características principales de esta actividad fue la implementación de una plataforma digital que permitió gestionar el desarrollo del bingo de manera interactiva. Los participantes pudieron ingresar desde sus dispositivos móviles mediante un código QR o utilizando el código de acceso de la sala.\r\n\r\nLa plataforma incorporó una tienda virtual de cartones, donde los participantes podían adquirir sus oportunidades de juego por un valor de $1.00 cada cartón. Cada usuario disponía de sus propios cartones digitales, en los cuales podía visualizar los números correspondientes y seguir el avance de cada ronda.\r\n\r\nDurante el desarrollo del juego, los números sorteados se mostraban en pantalla, permitiendo que los participantes identificaran y marcaran sus coincidencias en tiempo real. De esta manera, se aprovechó la tecnología para facilitar la organización y ofrecer una experiencia diferente a los asistentes.\r\n\r\nEl uso de esta herramienta digital permitió observar cómo el desarrollo de aplicaciones web puede incorporarse en actividades recreativas, facilitando la interacción entre los usuarios y promoviendo nuevas formas de participación.\r\n\r\nAdemás de ser un espacio de diversión y entrega de premios, el Gran Bingo fortaleció la convivencia, el compañerismo y la integración de los estudiantes de la Facultad Multidisciplinaria Oriental.\r\n\r\nEsta actividad formó parte de las experiencias desarrolladas durante la Semana de Sistemas SDS26 GREEN IoT, demostrando que la tecnología también puede convertirse en una herramienta para crear espacios de entretenimiento, creatividad y participación universitaria.	\N	published	2026-11-18 10:30:00	2026-11-20 03:44:55	2026-11-20 03:44:55	Comité organizador SDS26 GREEN IoT	8	2026-11-18
9	EXPO SYSTEM 2026: Proyectos e innovación tecnológica de Ingeniería de Sistemas Informáticos	expo-system-2026-proyectos-e-innovacion-tecnologica-de-ingenieria-de-sistemas-informaticos	EXPO SYSTEM 2026 fue un espacio de exposición académica en el que estudiantes de Ingeniería de Sistemas Informáticos de la Universidad de El Salvador, Facultad Multidisciplinaria Oriental, presentaron 18 proyectos tecnológicos desarrollados durante su formación universitaria. La actividad permitió conocer diferentes soluciones relacionadas con programación, inteligencia artificial, aplicaciones web, bases de datos, electrónica, simulaciones y otras áreas de la informática.	EXPO SYSTEM 2026: Innovación, creatividad y talento tecnológico en la UES-FMO\r\n\r\nEl 19 de noviembre de 2026 se llevó a cabo EXPO SYSTEM 2026, una de las actividades de la Semana de Sistemas SDS26 GREEN IoT, desarrollada en la Universidad de El Salvador, Facultad Multidisciplinaria Oriental (UES-FMO).\r\n\r\nDurante esta jornada, los estudiantes de Ingeniería de Sistemas Informáticos tuvieron la oportunidad de presentar y compartir con la comunidad universitaria los proyectos tecnológicos que han desarrollado como parte de su formación académica.\r\n\r\nEn esta edición se presentaron 18 proyectos, en los cuales se evidenció la creatividad, el conocimiento, la dedicación y las habilidades adquiridas por los estudiantes en las diferentes áreas de la informática.\r\n\r\nEntre las propuestas y demostraciones presentadas se pudieron conocer:\r\n\r\n1. Campus Connect FMO: sistema interactivo de mapeo de edificios universitarios y registro de presencia en tiempo real.\r\n\r\n2. BlinkCare+: propuesta tecnológica que utiliza visión artificial para reconocer el entorno y proporcionar indicaciones mediante voz.\r\n\r\n3. Risk Matemático versión Salvadoreña: proyecto interactivo que incorpora elementos de simulación y análisis matemático.\r\n\r\n4. Plataformas de entretenimiento digital: demostraciones de juegos y aplicaciones interactivas, como Basta! Online.\r\n\r\n5. Sistemas de análisis de datos: herramientas orientadas a la interpretación de información y apoyo a la toma de decisiones.\r\n\r\n6. Administración de servidores y servicios informáticos: demostraciones relacionadas con la configuración y funcionamiento de infraestructura tecnológica.\r\n\r\n7. Proyectos de electrónica e innovación: propuestas que integran componentes físicos, sensores y programación.\r\n\r\nAsimismo, se presentaron otras soluciones enfocadas en el desarrollo de aplicaciones web, dispositivos móviles, inteligencia artificial, bases de datos y diferentes herramientas tecnológicas.\r\n\r\n## Aprendizaje llevado a la práctica\r\n\r\nEXPO SYSTEM permitió que los estudiantes no solamente mostraran sus proyectos, sino que también explicaran sus funcionalidades, realizaran demostraciones y compartieran con los visitantes el proceso de desarrollo de sus propuestas.\r\n\r\nEsta experiencia representa una oportunidad para poner en práctica los conocimientos adquiridos en las aulas, fortalecer el trabajo en equipo, desarrollar habilidades de comunicación y demostrar cómo la tecnología puede contribuir a resolver diferentes necesidades de la sociedad.\r\n\r\n## Una carrera que construye el futuro\r\n\r\nLa presentación de estos proyectos refleja el esfuerzo colectivo de los estudiantes de Ingeniería de Sistemas Informáticos, quienes mediante sus ideas y conocimientos demuestran que la innovación comienza con la capacidad de identificar problemas y desarrollar soluciones.\r\n\r\nLa Semana de Sistemas 2026 permitió reconocer el talento estudiantil y destacar el papel de la formación universitaria en el desarrollo tecnológico.\r\n\r\nEXPO SYSTEM 2026 fue más que una exposición de proyectos: fue una muestra del compromiso, la creatividad y el potencial de los futuros profesionales de la informática de la UES-FMO.\r\n\r\nLa tecnología no solamente se aprende, también se construye, se comparte y se transforma en soluciones para el futuro.	\N	published	2026-11-19 10:30:00	2026-11-20 04:16:18	2026-11-20 04:16:18	Estudiantes de Ingeniería de Sistemas Informáticos de la UES-FMO	4	2026-11-19
10	Comelona Pizza 2026: sabor, emoción y diversión en la Semana de Sistemas	comelona-pizza-2026-sabor-emocion-y-diversion-en-la-semana-de-sistemas	La Semana de Sistemas 2026 también estuvo llena de diversión y convivencia con la actividad Comelona Pizza, una competencia en la que los participantes tuvieron 15 minutos para demostrar quién podía terminar su pizza primero. El primer lugar fue para el Ing. José Alexander Guandique Flores, quien se llevó el reconocimiento de esta entretenida dinámica.	# Comelona Pizza 2026: sabor, emoción y diversión en la Semana de Sistemas\r\n\r\nComo parte de las actividades recreativas de la Semana de Sistemas 2026, desarrollada en la Universidad de El Salvador, Facultad Multidisciplinaria Oriental (UES-FMO), se llevó a cabo la divertida competencia denominada «Comelona Pizza».\r\n\r\nEsta dinámica reunió a estudiantes y docentes en un ambiente de alegría, entusiasmo y compañerismo, convirtiéndose en uno de los momentos recreativos de la jornada.\r\n\r\n## ¿En qué consistió la competencia?\r\n\r\nEl reto consistió en que cada participante debía comer su pizza dentro de un tiempo reglamentario de 15 minutos. La dinámica tenía una regla principal: el primero en terminar su pizza sería declarado ganador.\r\n\r\nDurante el desarrollo de la competencia, los participantes pusieron a prueba su rapidez y capacidad para completar el desafío, mientras los asistentes observaban y animaban a los concursantes.\r\n\r\nLos 15 minutos establecidos mantuvieron la expectativa hasta el final, haciendo de esta actividad un momento entretenido para todos los presentes.\r\n\r\n## Ganador de la competencia\r\n\r\nEl primer lugar fue obtenido por el Ing. José Alexander Guandique Flores, quien logró cumplir el desafío y se llevó el reconocimiento como ganador de la Comelona Pizza 2026.\r\n\r\nSu participación destacó en esta competencia, que permitió compartir una experiencia diferente dentro de las actividades programadas para la Semana de Sistemas.\r\n\r\n## Un espacio para compartir y disfrutar\r\n\r\nMás allá de la competencia, Comelona Pizza representó una oportunidad para fortalecer la convivencia entre estudiantes, docentes y miembros de la comunidad de Ingeniería de Sistemas Informáticos.\r\n\r\nLa Semana de Sistemas no solamente busca promover el conocimiento, la innovación y el desarrollo tecnológico, sino también generar espacios de integración donde todos puedan compartir, disfrutar y crear recuerdos.\r\n\r\nCon actividades como esta, la UES-FMO demuestra que la vida universitaria también está llena de experiencias, compañerismo y momentos especiales.\r\n\r\n¡Porque en la Semana de Sistemas también hay espacio para la diversión, la convivencia y, por supuesto, una buena pizza!	\N	published	2026-11-19 01:00:00	2026-11-20 04:25:12	2026-11-20 04:25:12	Estudiantes de Ingeniería de Sistemas Informáticos de la UES-FMO	8	2026-11-19
11	TORNEO DE FUTBOL SALA	torneo-de-futbol-sala	Torneo de fútbol sala de la Semana de Sistemas 2026, en el que participaron 7 equipos en una jornada llena de emoción, compañerismo y espíritu deportivo. Una actividad que promovió la convivencia, la integración y la sana competencia entre los participantes. Donde se corono campeon Jefrey y sus amigos	Como parte de las actividades de la Semana de Sistemas 2026, se desarrolló un emocionante torneo de fútbol sala con la participación de 7 equipos, quienes demostraron sus habilidades, esfuerzo y pasión por el deporte.\r\n\r\nDurante la jornada, los participantes protagonizaron encuentros llenos de entusiasmo y competitividad, compartiendo momentos de convivencia y trabajo en equipo.\r\n\r\nEsta actividad permitió fortalecer los lazos entre estudiantes y promover valores como el respeto, la disciplina, la solidaridad y el compañerismo, demostrando que la Semana de Sistemas también es un espacio para el deporte, la recreación y la integración de la comunidad universitaria.\r\nLos equipos participantes fueron \r\nJefrey y sus amigos\r\nEl city rojo\r\nDocker compose.yml\r\nIndustriales\r\nJunta Directiva\r\nLegion 7\r\nToken FC	\N	published	2026-11-21 00:36:00	2026-11-21 06:40:03	2026-11-21 06:40:03	COMITE ORGANIZADOR	6	2026-11-20
12	Parrillada y convivencia estudiantil  Semana de Sistemas 2026	parrillada-y-convivencia-estudiantil-semana-de-sistemas-2026	Jornada de parrillada realizada durante la Semana de Sistemas 2026, como un espacio de convivencia, integración y compañerismo entre estudiantes de Ingeniería de Sistemas Informáticos. Una actividad en la que también tuve la oportunidad de colaborar en la distribución y entrega de alimentos.	Durante la Semana de Sistemas 2026 se desarrolló una jornada de parrillada, organizada como un espacio de convivencia e integración para los estudiantes de Ingeniería de Sistemas Informáticos.\r\n\r\nDurante esta actividad tuve la oportunidad de participar y colaborar directamente en la distribución y entrega de alimentos, apoyando a mis compañeros y contribuyendo al desarrollo de la jornada.\r\n\r\nMás allá de compartir una comida, esta experiencia permitió fortalecer los lazos de compañerismo, solidaridad y trabajo en equipo, demostrando que la vida universitaria también se construye mediante la participación y la colaboración en actividades fuera del aula.\r\n\r\nFue una jornada agradable en la que compartimos momentos especiales, fortaleciendo la unión de nuestra comunidad estudiantil.\r\n\r\nCrédito de la actividad: Ing. Diego Armando Herrera.\r\n\r\nSemana de Sistemas 2026 Ingeniería de Sistemas Informáticos.	\N	published	2026-11-20 13:00:00	2026-11-21 06:43:28	2026-11-21 06:45:54	COMITE ORGANIZADOR	7	2026-11-21
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
alorlCC9KuVzEV34fXrtvAnlqrukotcpkjFWLxHq	1	172.24.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36 Edg/157.0.0.0	YTo1OntzOjY6Il90b2tlbiI7czo0MDoicExWcUlMVGszRlVBV05VWWNsRjBqM0VhNXduVWI3VnBQalhyRzlhQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9ibG9nLXNlbWFuYS1zaXN0ZW1hcy5sb2NhbGhvc3Q6ODA4My9wdWJsaWNhY2lvbmVzIjtzOjU6InJvdXRlIjtzOjEwOiJibG9nLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNzk0NzljOThjN2FmM2JkZWUxYzYyYTUxYTNjMjE4NDhjNDYzY2UwNjdhNjM1NjQ2MDkxNDQwODE2MWFmYzNjZiI7fQ==	1795243561
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, is_admin) FROM stdin;
2	Isaias Leonel Cañas Rosa	isaiasleonel2004@gmail.com	\N	$2y$12$Rqn4DB16cqiQUQbcViuBBOPiBd7rWwxHJw89aBJfp9NQcxVYpQaw.	\N	2026-11-17 14:37:15	2026-11-17 14:37:15	f
1	Administrador SDS	admin@blogsds2026.com	\N	$2y$12$iq0NZ66Bpa3ytn1waQ2mWuBe2zFwhVlPCsb3SjpUgSGEgSCD.Ur3m	\N	2026-11-17 05:54:53	2026-11-17 14:34:18	t
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categories_id_seq', 9, true);


--
-- Name: evidence_attachments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.evidence_attachments_id_seq', 32, true);


--
-- Name: evidences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.evidences_id_seq', 26, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 16, true);


--
-- Name: publication_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.publication_images_id_seq', 64, true);


--
-- Name: publications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.publications_id_seq', 12, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories categories_name_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_unique UNIQUE (name);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: evidence_attachments evidence_attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidence_attachments
    ADD CONSTRAINT evidence_attachments_pkey PRIMARY KEY (id);


--
-- Name: evidences evidences_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidences
    ADD CONSTRAINT evidences_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: publication_images publication_images_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publication_images
    ADD CONSTRAINT publication_images_pkey PRIMARY KEY (id);


--
-- Name: publications publications_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publications
    ADD CONSTRAINT publications_pkey PRIMARY KEY (id);


--
-- Name: publications publications_slug_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publications
    ADD CONSTRAINT publications_slug_unique UNIQUE (slug);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: evidences_evidence_date_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evidences_evidence_date_index ON public.evidences USING btree (evidence_date);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: publication_images_publication_id_position_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX publication_images_publication_id_position_index ON public.publication_images USING btree (publication_id, "position");


--
-- Name: publications_activity_date_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX publications_activity_date_index ON public.publications USING btree (activity_date);


--
-- Name: publications_status_published_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX publications_status_published_at_index ON public.publications USING btree (status, published_at);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: evidence_attachments evidence_attachments_evidence_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidence_attachments
    ADD CONSTRAINT evidence_attachments_evidence_id_foreign FOREIGN KEY (evidence_id) REFERENCES public.evidences(id) ON DELETE CASCADE;


--
-- Name: evidences evidences_participant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidences
    ADD CONSTRAINT evidences_participant_id_foreign FOREIGN KEY (participant_id) REFERENCES public.users(id) ON DELETE RESTRICT;


--
-- Name: evidences evidences_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evidences
    ADD CONSTRAINT evidences_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: publication_images publication_images_publication_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publication_images
    ADD CONSTRAINT publication_images_publication_id_foreign FOREIGN KEY (publication_id) REFERENCES public.publications(id) ON DELETE CASCADE;


--
-- Name: publications publications_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.publications
    ADD CONSTRAINT publications_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

\unrestrict UG0zrRUKnAcY6uKreUHFQmsx81YpCU7fL83eJlFDjXp4Flu2KyZpSdunDfJtMlf

