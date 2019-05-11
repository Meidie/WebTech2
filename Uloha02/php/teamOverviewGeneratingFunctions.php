<?php
include_once 'config.php';

$GLOBALS['conn']=$conn;

function areThereRecordsOfTeams(){

    $sql = "SELECT * FROM timy";
    $result = $GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0)
        return true;
    else
        return false;

}

function generateRecords(){

    echo "<tr class=\"header\">";

    echo "<td> 42</td>";

    echo "<td> 55.5</td>";

    echo "<td> Prebieha hlasovanie</td>";

    echo "</tr>";


}

function stateOfteam(){

}



/*

 <tr class="header">
            <td> 42</td>
            <td> 55.5</td>
            <td> Prebieha hlasovanie</td>
        </tr>

        <tr class="overview">

            <td class="col-sm" colspan="3">
                <table class="table">
                    <thead>
                    <tr>
                        <td class="mail">Email </td>
                        <td>Meno </td>
                        <td>Body </td>
                        <td>Suhlas </td>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>xmacakn@gmail.com </td>
                        <td>Nicolas Macak </td>
                        <td>25 </td>
                        <td><img alt="palec" class="agreementIcon" src="../teamOverviewIcons/studentAgree.png"> </td>

                    </tr>
                    <tr>
                        <td>xpohancenikm@gmail.com </td>
                        <td>Matus Pohancenik </td>
                        <td>30 </td>
                        <td>Dosnt </td>

                    </tr>
                    </tbody>
                </table>


            </td>

        </tr>

        <tr class="overview">
            <td>Rozhodnutie administrátora</td>
            <td colspan="2">
                <button type="button"  class="btn btn-success" >Súhlasím</button>
                <button type="button"  class="btn btn-danger" >Nesúhlasím</button>
            </td>
        </tr>



 */

