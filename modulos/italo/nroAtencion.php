<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); // 300 seconds = 5 minutes

$statusValue = '';
$FechaValue = '';
$tipoDocValue = '';
$docEstValue = '';
$numAteValue = '';
$NumDoc = '';
$message = '';

if (isset($_POST['search'])) {
    if (isset($_POST['NumDoc']) && !empty($_POST['NumDoc'])) {
        $NumDoc = $_POST['NumDoc'];

        $sql = "SELECT [DocEntry], [DocNum], [Status], [CreateDate], [U_TIPODOC], [U_DOCEST], [U_NUMATE]
                FROM [SBO_Imp_Eximben_SAC].[dbo].[@OSVE]
                WHERE [DocNum] = '" . $NumDoc . "'";

        $rsNumAte = odbc_exec($conn, $sql);
        $resultado = odbc_fetch_array($rsNumAte);

        if ($resultado) {
            $statusValue = $resultado['Status'];
            $FechaValue = $resultado['CreateDate'];
            $tipoDocValue = $resultado['U_TIPODOC'];
            $docEstValue = $resultado['U_DOCEST'];
            $numAteValue = $resultado['U_NUMATE'];
        } else {
            $message = "No se encontró el documento.";
        }
    }
} elseif (isset($_POST['update'])) {
    if (isset($_POST['NumDoc']) && !empty($_POST['NumDoc']) && isset($_POST['NumAte']) && !empty($_POST['NumAte'])) {
        $NumDoc = $_POST['NumDoc'];
        $NumAte = $_POST['NumAte'];

        $updateSql = "UPDATE [SBO_Imp_Eximben_SAC].[dbo].[@OSVE]
                      SET [U_NUMATE] = '" . $NumAte . "'
                      WHERE [DocNum] = '" . $NumDoc . "'";

        odbc_exec($conn, $updateSql);
        
        $message = "Número de atención actualizado correctamente.";
    }
}
?>

<div id="content">
<form id="horizontalForm" name="horizontalForm" action="" method="POST">
    <fieldset>
        <legend>Actualizar Numero de Atención</legend>
        <fieldset style="width:210px;">
            <label for="DocNum">
                Numero Documento
                <input name="NumDoc" id="NumDoc" type="text" value="<?php echo isset($NumDoc) ? $NumDoc : ''; ?>" />
            </label>
            <label for="Status">
                Status Documento
                <input name="Status" id="Status" type="text" value="<?php echo $statusValue; ?>" readonly />
            </label>
            <label for="Fecha">
                Fecha Documento
                <input name="Fecha" id="Fecha" type="text" value="<?php echo $FechaValue; ?>" readonly />
            </label>
            <label for="TipoDoc">
                Tipo Documento
                <input name="TipoDoc" id="TipoDoc" type="text" value="<?php echo $tipoDocValue; ?>" readonly />
            </label>
            <label for="EstDoc">
                Estado Documento
                <input name="EstDoc" id="EstDoc" type="text" value="<?php echo $docEstValue; ?>" readonly />
            </label>
            <label for="NumAte">
                Numero Atencion
                <input name="NumAte" id="NumAte" type="text" value="<?php echo $numAteValue; ?>"  />
            </label>
            <input class="submit" type="submit" value="Buscar" id="search" name="search" />
            <input class="submit" type="submit" value="Actualizar" id="update" name="update"  />
        </fieldset>
    </fieldset>
</form>
<div id="message"><?php echo $message; ?></div>
</div>

<?php
// Aquí puedes agregar cualquier lógica adicional
?>
