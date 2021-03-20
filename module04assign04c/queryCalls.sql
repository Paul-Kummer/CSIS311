/*
call newUser('Paul', 'Kummer');
call validPass('computer', 'computer');
call validPass('1','computer');
call validPass('1', 'comp');
insert into USER (uID , uName , uPass )
values(0, "Computer A.I.", sha2("password",256));
*/



select * from SESSION;
select * from USER;
select * from TEST;
select * from PLAYS;

/* DON"T TOUCH THESE
truncate table PLAYS;
truncate table TEST;
truncate table SESSION;
*/



/*
call test("this worked");
call startGame("2");
select * from SESSION;
call addTurn("2", "1", "1", "Test of Test", "T", "00");
call addTurn("2", "2", "2", "Test of Test", "T", "00");
select * from PLAYS;
call showCurGame("2");
call getUserID("Steve");
call getGameID("2");
*/
