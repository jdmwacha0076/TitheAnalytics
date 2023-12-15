<?php
include '../configurations.php';
include '../functions.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $selectedKandaId = $_POST['kanda'];
        $jumuiya = getJumuiyaByKandaId($selectedKandaId);
        foreach ($jumuiya as $jumuiyaItem) {
            echo '<option value="' . $jumuiyaItem['id'] . '">' . $jumuiyaItem['name'] . '</option>';
        }

        exit();
    } else {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phoneNumber = $_POST['phoneNumber'];
        $jumuiya_name = $_POST['jumuiya_name'];

        $success = AddMembers($firstName, $lastName, $phoneNumber, $jumuiya_name);

        if ($success) {

            $_SESSION['member_added'] = true;
        }
    }
}

function getKandasFromDatabase()
{
    global $conn;

    $sql = "SELECT id, name FROM kanda";
    $result = $conn->query($sql);

    $kandasData = [];
    while ($row = $result->fetch_assoc()) {
        $kandasData[] = $row;
    }

    return $kandasData;
}

function getJumuiyaByKandaId($kandaId)
{
    global $conn;

    $sql = "SELECT id, name FROM jumuiyas WHERE kanda_id = $kandaId";
    $result = $conn->query($sql);

    $jumuiyaData = [];
    while ($row = $result->fetch_assoc()) {
        $jumuiyaData[] = $row;
    }

    return $jumuiyaData;
}
?>

<?php include './navbar.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="rowx">
                <div class="col-md-12">
                    <div class="register-icons" style="display: inline-block; margin-right: 20px;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="d-inline-block custom-heading">Sajili Mtoa Zaka Mpya</h2>
                </div>
            </div>

            <?php if (isset($success)) { ?>
                <?php if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Amesajiliwa Kikamilifu
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger" role="alert">
                        Hajasajiliwa Kikamilifu
                    </div>
                <?php } ?>
            <?php } ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="firstName">Jina la Kwanza:</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Jina la Mwisho:</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Nambari ya Simu: </label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" title="Enter a valid phone number (e.g., 0123456789)" oninput="transformPhoneNumber(this)" required>
                    <small class="form-text text-muted">Umbizo: 0xxxxxxxxx</small>
                </div>
                <div class="form-group">
                    <label for="kanda">Chagua Kanda:</label>
                    <select id="kanda" name="kanda" class="form-control">

                        <?php

                        $kandas = getKandasFromDatabase();

                        foreach ($kandas as $kanda) {
                            echo '<option value="' . $kanda['id'] . '">' . $kanda['name'] . '</option>';
                        }
                        ?>

                    </select> <br>

                    <label for="jumuiya_name">Chagua Jumuiya:</label>
                    <select id="jumuiya_name" name="jumuiya_name" class="form-control">

                    </select>

                </div>

                <button type="submit" class="btn btns-primary">Kamilisha Usajili</button>
            </form>
        </div>
    </div>

    <?php include '../footer.php'; ?>

</body>

<!--Script for formatting the phone number-->
<script>
    function transformPhoneNumber(input) {
        let cleanedInput = input.value.replace(/\D/g, '');
        cleanedInput = cleanedInput.substring(0, 12);
        if (cleanedInput.indexOf('0') === 0) {
            cleanedInput = '255' + cleanedInput.substring(1);
        }
        input.value = cleanedInput;
    }
</script>

<!--Script to display jumuiya after kanda-->
<script>
    document.getElementById('kanda').addEventListener('change', function() {
        var selectedKandaId = this.value;
        $.ajax({
            type: 'POST',
            url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
            data: {
                kanda: selectedKandaId
            },
            success: function(response) {
                $('#jumuiya_name').html(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
</script>