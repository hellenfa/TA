<table class="table table-primary">
    <thead>
    <tr>
        <th>ID</th>
        <th>GRUP</th>
        <th>des</th>
    </tr>
    </thead>
    <?php foreach ($grup as $data): ?>
    <tr>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->name; ?></td>
        <td><?php echo $data->description; ?></td>
    </tr>
    <?php endforeach; ?>
</table>