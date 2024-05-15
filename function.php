
<?php
  if(isset($_FILES['files'])){

  $folder = "uploads/";

  $names = $_FILES['files']['name'];
  $tmp_names = $_FILES['files']['tmp_name'];

  $upload_data = array_combine($tmp_names, $names);

  highlight_string("<?php " . var_export($upload_data, true) . ";?>");

  foreach($upload_data as $tmp_folder => $file){
    move_uploaded_file($tmp_folder, $folder.$file);
  }
  return "success";
}
