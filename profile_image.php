
<?php if (isset($_SESSION['id'])): ?>
    <?php
    $user_id = $_SESSION['id'];
    $query = "SELECT profile_image FROM users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profile_image = $row['profile_image'];
    }
    ?>

    <?php if (!empty($profile_image)): ?>
        <style>
            #profilkep-container {
                display: inline-block;
                margin-right: 10px;
            }

            #profilkep {
                width: 50px; 
                height: 50px;
                border-radius: 50%;
                cursor: pointer;
            }

            #change-profile-link {
                text-decoration: none;
                color: #333;
                cursor: pointer;
                margin-left: 5px;
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                overflow: auto;
            }

            .modal-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                max-width: 80%;
                max-height: 80%;
                margin: auto;
            }

            .close {
                color: #fff;
                font-size: 24px;
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
            }
        </style>

<div id="profilkep-container">
    <a href="#" id="view-profile-image">
        <?php echo '<img id="profilkep" src="' . $profile_image . '" alt="Profilkép">'; ?>
    </a>
    <a href="#" id="change-profile-link">Profilkép csere</a>
</div>

        <form id="profileImageForm" method="post" enctype="multipart/form-data" style="display: none;">
            <input type="file" name="new_profile_image" id="fileInput" accept="image/*">
        </form>
        <script>
            var profilkepContainer = document.getElementById('profilkep-container');
    var changeProfileLink = document.getElementById('change-profile-link');

    profilkepContainer.addEventListener('mouseenter', function () {
        changeProfileLink.style.display = 'block';
    });

    profilkepContainer.addEventListener('mouseleave', function () {
        changeProfileLink.style.display = 'none';
    });
            document.getElementById('profilkep-container').addEventListener('click', function () {
                openProfileModal();
            });

            document.getElementById('change-profile-link').addEventListener('click', function () {
                openFileInput();
            });

            function openProfileModal() {
                var modal = document.getElementById('profileImageModal');
                if (!modal) {
                    modal = document.createElement('div');
                    modal.id = 'profileImageModal';
                    modal.className = 'modal';
                    modal.innerHTML = '<div class="modal-content"><span class="close" onclick="closeModal()">&times;</span><img src="' + '<?php echo $profile_image; ?>' + '" alt="Profilkép"></div>';
                    document.body.appendChild(modal);
                } else {
                    modal.style.display = 'block';
                }
            }

            function closeModal() {
                var modal = document.getElementById('profileImageModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }

            function openFileInput() {
                // Képfeltöltő űrlap megjelenítése
                var fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/*';

                fileInput.addEventListener('change', function () {
                    uploadProfileImage(fileInput.files[0]);
                });

                fileInput.click();
            }

            function uploadProfileImage(file) {
                var formData = new FormData();
                formData.append('new_profile_image', file);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'change_profile_image.php', true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('profilkep').src = URL.createObjectURL(file);
                        closeModal();
                    } else {
                        alert('Hiba történt a kép feltöltése során.');
                    }
                };

                xhr.send(formData);
            }
        </script>
    <?php endif; ?>
<?php endif; ?>
