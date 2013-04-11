<h1 class="span16">Dashboard</h1>
<div class="span-one-third">
    <h2>Call Summary for Today</h2>
    <table>
        <thead></thead>
        <tbody>
            <tr>
                <td>Total Calls</td>
                <td class="r"><?php echo $calls['calls'];?></td>
            </tr>
            <tr>
                <td>Total Minutes</td>
                <td class="r"><?php echo \format::seconds_to_minutes($calls['total_minutes']);?></td>
            </tr>
            <tr>
                <td>Average Call Length</td>
                <td class="r"><?php echo \format::seconds_to_minutes($calls['average_minutes']);?></td>
            </tr>
            <tr>
                <td>Longest Call</td>
                <td class="r"><?php echo \format::seconds_to_minutes($calls['max_minutes']);?></td>
            </tr>
        </tbody>
    </table>
</div>
<div style="height: 400px;"></div>