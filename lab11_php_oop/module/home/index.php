<div class="card">

    <h2>Form Input User</h2>

    <?php
    // Form
    $form = new Form(BASE_URL . 'home/index', "Simpan Data");

    $form->addField("nama", "Nama Lengkap");
    $form->addField("email", "Email");
    $form->addField("pass", "Password", "password");
    $form->addField("jenis_kelamin", "Jenis Kelamin", "radio", [
        'L' => 'Laki-laki',
        'P' => 'Perempuan'
    ]);
    $form->addField("agama", "Agama", "select", [
        'Islam' => 'Islam',
        'Kristen' => 'Kristen',
        'Katolik' => 'Katolik',
        'Hindu' => 'Hindu',
        'Budha' => 'Budha'
    ]);
    $form->addField("hobi", "Hobi", "checkbox", [
        'Membaca' => 'Membaca',
        'Coding' => 'Coding',
        'Traveling' => 'Traveling'
    ]);
    $form->addField("alamat", "Alamat Lengkap", "textarea");

    // Proses Submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nama          = trim($_POST['nama'] ?? '');
        $email         = trim($_POST['email'] ?? '');
        $pass          = $_POST['pass'] ?? '';
        $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
        $agama         = $_POST['agama'] ?? '';
        $hobi_array    = $_POST['hobi'] ?? [];
        $alamat        = trim($_POST['alamat'] ?? '');

        $hobi = is_array($hobi_array) ? implode(',', $hobi_array) : '';

        // set ulang value form
        $form->setFieldValue('nama', $nama);
        $form->setFieldValue('email', $email);
        $form->setFieldValue('jenis_kelamin', $jenis_kelamin);
        $form->setFieldValue('agama', $agama);
        $form->setFieldValue('hobi', $hobi_array);
        $form->setFieldValue('alamat', $alamat);

        // Validasi
        if ($nama === '' || $email === '' || $pass === '') {
            echo "<div style='color:red; margin-bottom:10px;'>
                    Nama, Email, dan Password wajib diisi!
                  </div>";
        } else {

            // DATA SESUAI DATABASE
            $data = [
                'nama'           => $nama,
                'email'          => $email,
                'password'       => password_hash($pass, PASSWORD_DEFAULT),
                'jenis_kelamin'  => $jenis_kelamin,
                'agama'          => $agama,
                'hobi'           => $hobi,
                'alamat'         => $alamat
            ];

            if ($db->insert('users', $data)) {
                echo "<div style='color:green; margin-bottom:10px;'>
                        Data berhasil disimpan!
                      </div>";
                $form = new Form(BASE_URL . 'home/index', "Simpan Data");
            } else {
                echo "<div style='color:red; margin-bottom:10px;'>
                        Gagal menyimpan data ke database.
                      </div>";
            }
        }
    }

    $form->displayForm();
    ?>

</div>