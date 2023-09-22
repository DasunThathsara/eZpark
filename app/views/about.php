<?php require APPROOT.'/views/inc/header.php'; ?>
    <h1>Hello</h1>
    <?php foreach ($data['users'] as $user): ?>
        <p><?php echo $user->name.' - '.$user->age ?></p>
    <?php endforeach; ?>
<?php require APPROOT.'/views/inc/footer.php'; ?>
