<html><head>
    <title>log book</title>
    <style>

    </style>
</head><body>
<table>
    <tr>
        <td>Logbook</td>
        <td>: <?php echo $lb->logbook_name; ?></td>
    </tr>
    <tr>
        <td>Tanggal dibuat</td>
        <td>: <?php echo strftime('%A, %e %B %Y',strtotime($lb->create_date)); ?></td>
    </tr>
    <tr>
        <td>Penulis</td>
        <td>: <?php echo $this->logbook_model->get_nama_first_user($lb->id_user); ?></td>
    </tr>
    <tr>
        <td>Deskripsi</td>
        <td>: <?php echo $lb->description; ?></td>
    </tr>
</table>

</body></html>