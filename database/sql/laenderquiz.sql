/*==============================================================*/
/* DBMS name:      SAP SQL Anywhere 17                          */
/* Created on:     23.07.2021 00:44:51                          */
/*==============================================================*/


/*==============================================================*/
/* Table: LAND                                                  */
/*==============================================================*/
create table LAND 
(
   LID                  integer                        not null primary key,
   NAME                 varchar(1024)                  null,
   HAUPTSTADT           varchar(1024)                  null,
   FLAGGE               varchar(1024)                  null
);


/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   UID                  integer                        not null primary key,
   NAME                 varchar(1024)                  null,
   PASSWORT             varchar(1024)                  null,
   PUNKTE               integer                        null
);


/*==============================================================*/
/*  Constraint                                                  */
/*==============================================================*/
/*alter table LAND						*/
/*   add constraint FK_LAND_ERRAT_USER foreign key (UID)	*/
/*      references USER (UID);		     			*/

