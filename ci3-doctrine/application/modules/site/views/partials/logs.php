<div class="container mt-3">
    <h2>Event log</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Value</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($logs as $log) {
            /** @var \Entities\Log $log */
            ?>
            <tr>
                <td><?=$log->getId()?></td>
                <td><?=$log->getValue()?></td>
                <td><?=($log->getCreatedAt()->format('Y-m-d H:i:s')??'')?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

</div>