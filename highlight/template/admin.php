<?php
/**
 * @copyright (C) 2022, 299Ko
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
 * @author Maxence Cauderlier <mx.koder@gmail.com>
 * 
 * @package 299Ko https://github.com/299Ko/299ko
 */
defined('ROOT') OR exit('No direct script access allowed');

include_once(ROOT . 'admin/header.php');
?>
<form method="post" action="index.php?p=highlight&action=saveconf" enctype="multipart/form-data">
    <?php show::adminTokenField(); ?>
    <h3>Paramètres</h3>
    <p>
        <label for="theme-select">Thème à appliquer sur les codes</label><br>
        <select name="theme" id="theme-select">
            <?php
            foreach (highlightGetThemes() as $k => $v) {
                $s = "<option value='$k'";
                if ($runPlugin->getConfigVal('theme') === $k) {
                    $s .= ' selected';
                }
                $s .= ">$v</option>";
                echo $s;
            }
            ?>
        </select>
    </p>
    <p><button type="submit" class="button">Enregistrer</button></p>
</form>
<?php include_once(ROOT . 'admin/footer.php'); ?>