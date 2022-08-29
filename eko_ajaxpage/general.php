<?php 

 global $dbo;



$router->get('/', function() 
{
$page_title = "Dashboard | Home";
 include_once 'html_files/header.php';
 include_once 'pages/default.php';
 include_once 'html_files/footer.php';	


});
$router->get('/editProfile/{a}',  function($value)
{
$page_title = "Student View";
 include_once 'html_files/header.php';
 include_once 'pages/editStudent.php';
 include_once 'html_files/footer.php';	


});
$router->get('/DeleteStudent/{a}',  function($value)
{
$page_title = "Student View";
 include_once 'html_files/header.php';
 include_once 'pages/DeleteStudent.php';
 include_once 'html_files/footer.php';	


});
$router->get('/DeleteCourse/{a}',  function($value)
{
$page_title = "Student View";
 include_once 'html_files/header.php';
 include_once 'pages/DeleteCourse.php';
 include_once 'html_files/footer.php';	


});
$router->any('/AddStudent',  function()
{
$page_title = "Add Student";
 include_once 'html_files/header.php';
 include_once 'pages/AddStudent.php';
 include_once 'html_files/footer.php';	


});
$router->any('/404',  function()
{
$page_title = "404";
 include_once 'html_files/header.php';
 include_once 'pages/404.php';
 include_once 'html_files/footer.php';	


});
$router->any('/AllExam',  function()
{
$page_title = "All Student";
 include_once 'html_files/header.php';
 include_once 'pages/AllExam.php';
 include_once 'html_files/footer.php';	


});
$router->any('/LogOut',  function()
{
 include_once 'pages/LogOut.php';

});
$router->any('/AllCourse',  function()
{
$page_title = "All Course";
 include_once 'html_files/header.php';
 include_once 'pages/AllCourse.php';
 include_once 'html_files/footer.php';	


});
$router->any('/AddCourse',  function()
{
$page_title = "Add Course";
 include_once 'html_files/header.php';
 include_once 'pages/AddCourse.php';
 include_once 'html_files/footer.php';	


});
$router->any('/Login',  function()
{
$page_title = "Login";

 include_once 'pages/Login.php';



});
$router->any('/AddExam/{a}',  function($value)
{
$page_title = "Add Exam";
 include_once 'html_files/header.php';
 include_once 'pages/AddExam.php';
 include_once 'html_files/footer.php';	


});