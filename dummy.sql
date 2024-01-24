--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

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
-- Name: users_with_or_more_photos(integer); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.users_with_or_more_photos(min_count integer) RETURNS TABLE(userid integer, username character varying, email character varying, photos_count bigint)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
        SELECT users."userID", users.username, users.email, COUNT(*) FROM photos
        JOIN users ON photos."usersID" = users."userID"
        GROUP BY users."userID" HAVING COUNT(*) >= min_count;
END;
$$;


ALTER FUNCTION public.users_with_or_more_photos(min_count integer) OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: accountTypes; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."accountTypes" (
    "accountTypeID" integer NOT NULL,
    type character varying(255) NOT NULL
);


ALTER TABLE public."accountTypes" OWNER TO docker;

--
-- Name: AccountTypes_accountTypeID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."AccountTypes_accountTypeID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."AccountTypes_accountTypeID_seq" OWNER TO docker;

--
-- Name: AccountTypes_accountTypeID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."AccountTypes_accountTypeID_seq" OWNED BY public."accountTypes"."accountTypeID";


--
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    "userID" integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    "accountTypeID" integer DEFAULT 2 NOT NULL,
    "userDetailsID" integer
);


ALTER TABLE public.users OWNER TO docker;

--
-- Name: Users_UsersID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Users_UsersID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Users_UsersID_seq" OWNER TO docker;

--
-- Name: Users_UsersID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Users_UsersID_seq" OWNED BY public.users."userID";


--
-- Name: friendshipStatuses; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."friendshipStatuses" (
    "friendshipStatusID" integer NOT NULL,
    status character varying(255) NOT NULL
);


ALTER TABLE public."friendshipStatuses" OWNER TO docker;

--
-- Name: friendshipStatuses_friendshipStatusID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."friendshipStatuses_friendshipStatusID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."friendshipStatuses_friendshipStatusID_seq" OWNER TO docker;

--
-- Name: friendshipStatuses_friendshipStatusID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."friendshipStatuses_friendshipStatusID_seq" OWNED BY public."friendshipStatuses"."friendshipStatusID";


--
-- Name: friendships; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.friendships (
    "friendshipID" integer NOT NULL,
    "userID1" integer NOT NULL,
    "userID2" integer NOT NULL,
    "friendshipStatuesID" integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.friendships OWNER TO docker;

--
-- Name: friendship_count; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.friendship_count AS
 SELECT "friendshipStatuses".status,
    count(*) AS count
   FROM (public.friendships
     JOIN public."friendshipStatuses" ON ((friendships."friendshipStatuesID" = "friendshipStatuses"."friendshipStatusID")))
  WHERE (mod(friendships."friendshipID", 2) = 1)
  GROUP BY "friendshipStatuses".status;


ALTER VIEW public.friendship_count OWNER TO docker;

--
-- Name: friendships_friendshipID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."friendships_friendshipID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."friendships_friendshipID_seq" OWNER TO docker;

--
-- Name: friendships_friendshipID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."friendships_friendshipID_seq" OWNED BY public.friendships."friendshipID";


--
-- Name: photos; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.photos (
    "photoID" integer NOT NULL,
    name character varying(255) NOT NULL,
    path character varying(255) NOT NULL,
    "usersID" integer NOT NULL,
    description character varying(255) NOT NULL
);


ALTER TABLE public.photos OWNER TO docker;

--
-- Name: photos_photosID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."photos_photosID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."photos_photosID_seq" OWNER TO docker;

--
-- Name: photos_photosID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."photos_photosID_seq" OWNED BY public.photos."photoID";


--
-- Name: usersDetails; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."usersDetails" (
    "userDetailsID" integer NOT NULL,
    "firstName" character varying(255) NOT NULL,
    "lastName" character varying(255) NOT NULL
);


ALTER TABLE public."usersDetails" OWNER TO docker;

--
-- Name: users_with_account_types; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.users_with_account_types AS
 SELECT users.username,
    users.email,
    "accountTypes".type
   FROM (public.users
     JOIN public."accountTypes" ON ((users."accountTypeID" = "accountTypes"."accountTypeID")));


ALTER VIEW public.users_with_account_types OWNER TO docker;

--
-- Name: accountTypes accountTypeID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."accountTypes" ALTER COLUMN "accountTypeID" SET DEFAULT nextval('public."AccountTypes_accountTypeID_seq"'::regclass);


--
-- Name: friendshipStatuses friendshipStatusID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."friendshipStatuses" ALTER COLUMN "friendshipStatusID" SET DEFAULT nextval('public."friendshipStatuses_friendshipStatusID_seq"'::regclass);


--
-- Name: friendships friendshipID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.friendships ALTER COLUMN "friendshipID" SET DEFAULT nextval('public."friendships_friendshipID_seq"'::regclass);


--
-- Name: photos photoID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos ALTER COLUMN "photoID" SET DEFAULT nextval('public."photos_photosID_seq"'::regclass);


--
-- Name: users userID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN "userID" SET DEFAULT nextval('public."Users_UsersID_seq"'::regclass);


--
-- Data for Name: accountTypes; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."accountTypes" ("accountTypeID", type) FROM stdin;
1	admin
2	normal
\.


--
-- Data for Name: friendshipStatuses; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."friendshipStatuses" ("friendshipStatusID", status) FROM stdin;
1	pending
2	accepted
\.


--
-- Data for Name: friendships; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.friendships ("friendshipID", "userID1", "userID2", "friendshipStatuesID") FROM stdin;
4	3	1	2
3	1	3	2
1	1	2	2
2	2	1	2
15	5	1	1
16	1	5	1
\.


--
-- Data for Name: photos; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.photos ("photoID", name, path, "usersID", description) FROM stdin;
1	fffff	pawel-czerwinski-lWBZ01XRRoI-unsplash.jpg	3	fffffffffffffffffff
2	ggggg	anthony-delanoix-urUdKCxsTUI-unsplash.jpg	3	gggggggggggggg
3	cccccc	meina-yin-hkHcMvtsyoo-unsplash.jpg	1	ccccccccccccccccccccccccccc
4	yyyyyyyyyyy	shannon-baldwin-Z33hpeePdyc-unsplash.jpg	1	yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users ("userID", username, email, password, "accountTypeID", "userDetailsID") FROM stdin;
3	qwe	qwe@qwe.qwe	$2y$10$c22nEiLLmC4XUg5Nwwac3.etz0l/ZQ8nx9tQxzljOf3q/.T0TKYMC	2	\N
1	xyz	xyz@xyz.xyz	$2y$10$dTH7elK3QxTLOsO9u3mYsumbzK22uzFOFJNj4ISpf0JsZTK8w/FO6	1	\N
2	abc	abc@abc.abc	$2y$10$/Adgt20k82QXew44x/iRx.qTkknAC4OO5aRJ7B34w6hU7r8mqhYwW	1	\N
5	bnm	bnm@bnm.bnm	$2y$10$EH7iG9v4PCEveDpVpFVi1eZNNe7y.jNLyt.9Hz3P1baIHtRQgbEde	2	\N
\.


--
-- Data for Name: usersDetails; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."usersDetails" ("userDetailsID", "firstName", "lastName") FROM stdin;
\.


--
-- Name: AccountTypes_accountTypeID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."AccountTypes_accountTypeID_seq"', 2, true);


--
-- Name: Users_UsersID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Users_UsersID_seq"', 5, true);


--
-- Name: friendshipStatuses_friendshipStatusID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."friendshipStatuses_friendshipStatusID_seq"', 2, true);


--
-- Name: friendships_friendshipID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."friendships_friendshipID_seq"', 16, true);


--
-- Name: photos_photosID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."photos_photosID_seq"', 4, true);


--
-- Name: accountTypes accountTypes_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."accountTypes"
    ADD CONSTRAINT "accountTypes_pk" PRIMARY KEY ("accountTypeID");


--
-- Name: accountTypes accountTypes_pk2; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."accountTypes"
    ADD CONSTRAINT "accountTypes_pk2" UNIQUE (type);


--
-- Name: friendshipStatuses friendshipStatuses_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."friendshipStatuses"
    ADD CONSTRAINT "friendshipStatuses_pk" PRIMARY KEY ("friendshipStatusID");


--
-- Name: friendships friendships_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.friendships
    ADD CONSTRAINT friendships_pk PRIMARY KEY ("friendshipID");


--
-- Name: photos photos_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos
    ADD CONSTRAINT photos_pk PRIMARY KEY ("photoID");


--
-- Name: usersDetails usersDetails_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."usersDetails"
    ADD CONSTRAINT "usersDetails_pk" PRIMARY KEY ("userDetailsID");


--
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY ("userID");


--
-- Name: friendships friendships_friendshipStatuses_friendshipStatusID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.friendships
    ADD CONSTRAINT "friendships_friendshipStatuses_friendshipStatusID_fk" FOREIGN KEY ("friendshipStatuesID") REFERENCES public."friendshipStatuses"("friendshipStatusID");


--
-- Name: friendships friendships_users_userID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.friendships
    ADD CONSTRAINT "friendships_users_userID_fk" FOREIGN KEY ("userID1") REFERENCES public.users("userID") ON DELETE CASCADE;


--
-- Name: friendships friendships_users_userID_fk2; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.friendships
    ADD CONSTRAINT "friendships_users_userID_fk2" FOREIGN KEY ("userID2") REFERENCES public.users("userID") ON DELETE CASCADE;


--
-- Name: photos photos_users_usersID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos
    ADD CONSTRAINT "photos_users_usersID_fk" FOREIGN KEY ("usersID") REFERENCES public.users("userID");


--
-- Name: users users_accountTypes_accountTypeID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "users_accountTypes_accountTypeID_fk" FOREIGN KEY ("accountTypeID") REFERENCES public."accountTypes"("accountTypeID");


--
-- Name: users users_usersDetails_userDetailsID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "users_usersDetails_userDetailsID_fk" FOREIGN KEY ("userDetailsID") REFERENCES public."usersDetails"("userDetailsID") ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

