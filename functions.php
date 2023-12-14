<?php
function createMembersTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS members (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        jumuiya_id INT NOT NULL,
        FOREIGN KEY (jumuiya_id) REFERENCES jumuiya(id)
    )";

    return $conn->query($sql);
}

function insertMember($name, $jumuiya)
{
    global $conn;

    $sql = "INSERT INTO members (name, jumuiya_id) VALUES ('$name', $jumuiya)";

    return $conn->query($sql);
}

function AddMembers($firstName, $lastName, $phoneNumber, $jumuiya_name)
{
    global $conn;

    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
    $jumuiya_name = mysqli_real_escape_string($conn, $jumuiya_name);

    $sql = "INSERT INTO all_members (firstName, lastName, phoneNumber, jumuiya_name) VALUES ('$firstName', '$lastName', '$phoneNumber', '$jumuiya_name')";

    return $conn->query($sql);
}
