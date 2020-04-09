<?= $this->extend('layout') ?>
<?= $this->section('content') ;
//echo view_cell('App\Libraries\ViewHelper::dateTime');
?>

<div id="app">{{message}}</div>

<?= $this->endSection() ?>
