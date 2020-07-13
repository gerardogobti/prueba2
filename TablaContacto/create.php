<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$phone = $email = $direction = $facebook = $twitter = $whatsapp = $instagram = "";
$phone_err = $email_err = $direction_err = $facebook_err = $twitter_err =  $whatsapp_err = $instagram_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validando el campo titulo
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Por favor ingrese un titulo del producto o servicio.";     
    } else{
        $phone = $input_phone;
    }

    // Validando el campo de la descripcion
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor ingrese una descripcion del producto.";     
    } else{
        $email = $input_email;
    }

    // Validando el campo de Imagen
    $input_direction = trim($_POST["direction"]);
    if(empty($input_direction)){
        $direction_err = "Por favor ingrese una imagen del producto.";     
    } else{
        $direction = $input_direction;
    }

    // Validando el campo de Imagen
    $input_facebook = trim($_POST["facebook"]);
    if(empty($input_facebook)){
        $facebook_err = "Por favor ingrese una imagen del producto.";     
    } else{
        $facebook = $input_facebook;
    }
    
    // Validando el campo de Imagen
    $input_twitter = trim($_POST["twitter"]);
    if(empty($input_twitter)){
        $twitter_err = "Por favor ingrese una imagen del producto.";     
    } else{
        $twitter = $input_twitter;
    }

    // Validando el campo de Imagen
    $input_whatsapp = trim($_POST["whatsapp"]);
    if(empty($input_whatsapp)){
        $whatsapp_err = "Por favor ingrese una imagen del producto.";     
    } else{
        $whatsapp = $input_whatsapp;
    }

    // Validando el campo de Imagen
    $input_instagram = trim($_POST["instagram"]);
    if(empty($input_instagram)){
        $instagram_err = "Por favor ingrese una imagen del producto.";     
    } else{
        $instagram = $input_instagram;
    }



    // Check input errors before inserting in database
    if(empty($phone_err) && empty($email_err) && empty($direction_err) && empty($facebook_err) && empty($twitter_err) && empty($whatsapp_err) && empty($instagram_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO contact (phone, email, direction, facebook, twitter, whatsapp, instagram) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_phone, $param_email, $param_direction, $param_facebook, $param_twitter, $param_whatsapp, $param_instagram);
            
            // Set parameters
            $param_phone = $phone;
            $param_email = $email;
            $param_direction = $direction;
            $param_facebook = $facebook;
            $param_twitter = $twitter;
            $param_whatsapp = $whatsapp;
            $param_instagram = $instagram;
            
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Algo salio mal. Intentelo mas tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Productos y Servicios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h3>Agregar Contacto al SistemaAP</h3>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar los datos de contacto.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Telefono de Contacto:</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Correo de Contacto:</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($direction_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion de la Empresa :</label>
                            <textarea name="direction" class="form-control"><?php echo $direction; ?></textarea>
                            <span class="help-block"><?php echo $direction_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($facebook_err)) ? 'has-error' : ''; ?>">
                            <label>Facebook de Contacto:</label>
                            <input type="text" name="facebook" class="form-control" value="<?php echo $facebook; ?>">
                            <span class="help-block"><?php echo $facebook_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($twitter_err)) ? 'has-error' : ''; ?>">
                            <label>Twitter de Contacto:</label>
                            <input type="text" name="twitter" class="form-control" value="<?php echo $twitter; ?>">
                            <span class="help-block"><?php echo $twitter_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($whatsapp_err)) ? 'has-error' : ''; ?>">
                            <label>Whats App de Contacto:</label>
                            <input type="text" name="whatsapp" class="form-control" value="<?php echo $whatsapp; ?>">
                            <span class="help-block"><?php echo $whatsapp_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($instagram_err)) ? 'has-error' : ''; ?>">
                            <label>Instagram de Contacto:</label>
                            <input type="text" name="instagram" class="form-control" value="<?php echo $instagram; ?>">
                            <span class="help-block"><?php echo $instagram_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Agregar" >
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>