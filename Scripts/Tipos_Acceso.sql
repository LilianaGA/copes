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

Date: 2015-07-28 20:58:55
*/


-- ----------------------------
-- Table structure for "public"."Tipos_Acceso"
-- ----------------------------
DROP TABLE "public"."Tipos_Acceso";
CREATE TABLE "public"."Tipos_Acceso" (
"id" int4 DEFAULT nextval('"Tipos_Acceso_id_seq"'::regclass) NOT NULL,
"Descripcion" varchar(60) NOT NULL,
"remember_token" varchar(100),
"created_at" timestamp(6) NOT NULL,
"updated_at" timestamp(6) NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of Tipos_Acceso
-- ----------------------------
INSERT INTO "public"."Tipos_Acceso" VALUES ('1', 'Encargado', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Tipos_Acceso" VALUES ('2', 'Profesor', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Tipos_Acceso" VALUES ('3', 'Contador', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');
INSERT INTO "public"."Tipos_Acceso" VALUES ('4', 'Administrativo', null, '2015-05-12 00:00:00', '2015-05-12 00:00:00');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table "public"."Tipos_Acceso"
-- ----------------------------
ALTER TABLE "public"."Tipos_Acceso" ADD PRIMARY KEY ("id");
