/*
Navicat PGSQL Data Transfer

Source Server         : localhost
Source Server Version : 90204
Source Host           : localhost:5432
Source Database       : copes2
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90204
File Encoding         : 65001

Date: 2015-07-28 20:57:46
*/


-- ----------------------------
-- Table structure for "public"."Leccion_Hora"
-- ----------------------------
DROP TABLE "public"."Leccion_Hora";
CREATE TABLE "public"."Leccion_Hora" (
"id" int4 DEFAULT nextval('"Leccion_Hora_id_seq"'::regclass) NOT NULL,
"Numero" int4 NOT NULL,
"Hora" varchar(20) NOT NULL,
"remember_token" varchar(100),
"created_at" timestamp(6) NOT NULL,
"updated_at" timestamp(6) NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of Leccion_Hora
-- ----------------------------
INSERT INTO "public"."Leccion_Hora" VALUES ('1', '1', '7:00 am a 7:40 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('2', '2', '7:40 am a 8:20 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('3', '3', '8:30 am a 9:10 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('4', '4', '9:10 am a 9:50 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('5', '5', '9:50 am  a 10:30 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('6', '6', '11:00 am a 11:40 am', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('7', '7', '11:40 am a 12:20 pm', null, '2015-05-15 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('8', '8', '12:25 pm a 1:05 pm', ' ', '2015-05-15 00:00:00', '2015-05-15 00:00:00');
INSERT INTO "public"."Leccion_Hora" VALUES ('9', '9', '1:05 pm a 1:45 pm', null, '2015-05-15 00:00:00', '2015-05-15 00:00:00');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table "public"."Leccion_Hora"
-- ----------------------------
ALTER TABLE "public"."Leccion_Hora" ADD PRIMARY KEY ("id");
