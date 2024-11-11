<!DOCTYPE html>
<html lang="en">

<?php 

session_start();

if (isset($_SESSION['senha'])) {
    if($_SESSION['senha'] == "yohannalinda") {
    } else {
        header("/login.php");
    }
} else {
    header("Location: /login.php");
}

function gerarCodigoAleatorioImagem($tamanho = 16) {
    return bin2hex(random_bytes($tamanho));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $coat = $_POST['coat'];
    $size = $_POST['size'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];

    $photoName = "";

    if (isset($_FILES['photo'])) {
        $photoName = gerarCodigoAleatorioImagem();
        $photoTmpName = $_FILES['photo']['tmp_name'];
        $photoSize = $_FILES['photo']['size'];
        $photoType = $_FILES['photo']['type'];
        $path_parts = pathinfo($_FILES["photo"]["name"]);
        $extension = $path_parts['extension'];
        
        move_uploaded_file($photoTmpName, "uploads/" . $photoName . "." . $extension);
    }

    include_once("./services/conexao.php");

    $stmt;
    
    if($type == 'cachorro') {
        $stmt = $conn->prepare("INSERT INTO cachorros (sexo, porte, pelagem, foto, nome) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $gender, $size, $coat, $photoName, $name);
    } else {
        $stmt = $conn->prepare("INSERT INTO gatos (sexo, porte, pelagem, foto, nome) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $gender, $size, $coat, $photoName, $name);
    }


    if ($stmt->execute()) {
        echo "Novo registro criado com sucesso";
    } else {
        echo "Erro: " . $stmt->error;
    }


    $stmt->close();
    $conn->close();
}

?>

<?php include("./components/head.html"); ?>

<head>
<style>
        .container {
            display: table;
            margin: auto;
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .tabs {
            display: flex;
            margin-bottom: 1rem;
        }
        .tab {
            flex: 1;
            padding: 0.5rem;
            text-align: center;
            background-color: #e0e0e0;
            cursor: pointer;
            border: none;
            outline: none;
        }
        .tab.active {
            background-color: #4a90e2;
            color: white;
        }
        .tab:first-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .tab:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .radio-group {
            display: flex;
            gap: 1rem;
        }
        button[type="submit"] {
            width: 100%;
            padding: 0.75rem;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button[type="submit"]:hover {
            background-color: #3a7bc8;
        }
        #photoPreview {
            margin-top: 1rem;
            text-align: center;
        }
        #preview {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<?php include("./components/navbar.html"); ?>

<div class="container">
        <h1>Registro de Pets</h1>
        
        
        <form id="petForm" method='POST' action='registro.php' enctype="multipart/form-data">
            <div class="radio-group">
                <label>
                    <input type="radio" name="type" value="cachorro" required>
                    Cachorro
                </label>
                <label>
                    <input type="radio" name="type" value="gato" required>
                    Gato
                </label>
            </div>
            <div class="form-group">
                <label for="name">Nome do pet</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="age">Idade</label>
                <input type="text" id="age" name="age" required>
            </div>
            
            <div class="form-group">
                <label for="coat">Pelagem</label>
                <input type="text" id="coat" name="coat" required>
            </div>
            
            <div class="form-group">
                <label for="size">Porte</label>
                <select id="size" name="size" required>
                    <option value="">Selecione o porte</option>
                    <option value="pequeno">Pequeno</option>
                    <option value="medio">Médio</option>
                    <option value="grande">Grande</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Sexo</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="macho" required>
                        Macho
                    </label>
                    <label>
                        <input type="radio" name="gender" value="femea" required>
                        Fêmea
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="photo">Foto do Pet (máx. 30 MB)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                <div id="errorMessage"></div>
            </div>
            
            <div id="photoPreview" style="display: none;">
                <img id="preview" src="#" alt="Preview da foto do pet">
            </div>
            
            <button type="submit">Registrar Pet</button>
        </form>
    </div>

    <script>
        const dogTab = document.getElementById('dogTab');
        const catTab = document.getElementById('catTab');
        const form = document.getElementById('petForm');
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photoPreview');
        const preview = document.getElementById('preview');
        const errorMessage = document.getElementById('errorMessage');

        let currentPet = 'dog';

        dogTab.addEventListener('click', () => {
            dogTab.classList.add('active');
            catTab.classList.remove('active');
            currentPet = 'dog';
        });

        catTab.addEventListener('click', () => {
            catTab.classList.add('active');
            dogTab.classList.remove('active');
            currentPet = 'cat';
        });

        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 30 * 1024 * 1024) {
                    errorMessage.textContent = 'Erro: O tamanho máximo permitido é 30 MB.';
                    photoInput.value = '';
                    photoPreview.style.display = 'none';
                } else {
                    errorMessage.textContent = '';
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        photoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const petData = Object.fromEntries(formData.entries());
            petData.type = currentPet;
            
        
            const photoFile = photoInput.files[0];
            if (photoFile) {
                petData.photoName = photoFile.name;
                petData.photoSize = photoFile.size;
                petData.photoType = photoFile.type;
            }

            console.log('Pet registrado:', petData);
            alert(`${currentPet === 'dog' ? 'Cachorro' : 'Gato'} registrado com sucesso!`);
            form.reset();
            photoPreview.style.display = 'none';
        });
    </script>
</body>
</html>
