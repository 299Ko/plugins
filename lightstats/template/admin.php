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
<section>
    <h3>Sélections des dates de statistiques</h3>
    <form method="post" action="?p=lightstats">
        <p>
            <label for="dateStart">Date de début</label>
            <input id="dateStart" name="dateStart" type="date" value="<?php echo $inDateStart; ?>">
            <label for="dateEnd">Date de fin</label>
            <input id="dateEnd" name="dateEnd" type="date" value="<?php echo $inDateEnd; ?>">
        </p>
        <p>
            <button type="submit" class="button">Voir les statistiques</button>
        </p>
    </form>
</section>

<?php
if ($logsManager->hasLogs()) {
    ?>
    <section>
        <h3>Données quotidiennes sur la période : <?php echo $inDateStart . ' - ' . $inDateEnd ?></h3>
        <canvas id="graphStats"></canvas>
        <script>
            var ctx = document.getElementById('graphStats');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $chartDays; ?>],
                    datasets: [{
                            label: 'Visiteurs uniques',
                            data: [<?php echo $chartVisitors; ?>]
                        },
                        {
                            label: 'Pages vues',
                            data: [<?php echo $chartPages; ?>]
                        }]
                }
            });
        </script>
    </section>
    <section>
        <h3>Données sur la période : <?php echo $inDateStart . ' - ' . $inDateEnd ?></h3>
        <table id="lightStatsTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Page</th>
                    <th>Referer</th>
                    <th>Navigateur</th>
                    <th>OS</th>
                    <th>Robot ?</th>
                    <th>IP</th></tr></thead><tbody>
                <?php
                foreach ($logs as $stat) {
                    echo '<tr>';
                    echo '<td>' . $stat->date . '</td>';
                    echo '<td><a href="' . util::urlBuild($stat->page) . '">' . $stat->page . '</a></td>';
                    echo '<td><a href="' . $stat->referer . '">' . $stat->referer . '</a></td>';
                    echo '<td>' . $stat->browser . '</td>';
                    echo '<td>' . $stat->platform . '</td>';
                    echo '<td>' . ($stat->isBot ? 'Oui' : 'Non') . '</td>';
                    echo '<td>' . $stat->ip . '</td>';
                    echo '</tr></tbody>';
                }
                echo '<tfoot><tr><td colspan="4">Nombre de visiteurs uniques sur la période : ' . count($logsManager->uniquesVisitor) . ' </td>'
                . '<td colspan="3">Nombre de pages vues : ' . count($logs) . ' </td></tr></tfoot>';
                echo '</table></section>';
            } else {
                ?>
                Aucune donnée à afficher pour cette période.
                <?php
            }
            ?>

            <?php
            include_once(ROOT . 'admin/footer.php');
            