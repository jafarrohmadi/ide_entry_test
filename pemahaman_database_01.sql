CREATE DATABASE test_ide;

create table school
(
    id int auto_increment primary key,
    school_code varchar(20)  null,
    school_name varchar(100) null,
    inaugurated_date date null
);
