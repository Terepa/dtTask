<?php
require 'DBmethods.php';
$data = new Databases;
if (isset($_GET['searchBtn'])) {
    $search = $_GET['search'];
    $data->search = $search;
}
if (isset($_GET["sortBy"])) {
    $order = ($_GET['sortBy']);
    $data->order = $order;
} else {
    $order = "date";
}
if (isset($_GET["delete"])) {
    $where = $_GET["id"];
    $data->delete($where);
}
$post_data = $data->fetchdata('emails', "$order");
foreach ($post_data as $post) {
    array_push($data->domain, $post['email']);
}
$data->getDomainName();
if (isset($_GET["domain"])) {
    $search = $_GET['domain'];
    $data->search = $search;
    $post_data = $data->fetchdata('emails', "$order");
}
