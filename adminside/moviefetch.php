<?php
function getItems($con, $table, $page, $itemsPerPage, $orderBy = 'id', $order = 'DESC') {
    $offset = ($page - 1) * $itemsPerPage;
    $query = "SELECT * FROM $table ORDER BY $orderBy $order LIMIT $itemsPerPage OFFSET $offset";
    return $con->query($query);
}

function getTotalItems($con, $table) {
    $query = "SELECT COUNT(*) as total FROM $table";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>