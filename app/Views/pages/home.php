<!-- memanggil tamplate untuk page Home -->
<?= $this->extend('layout/template'); ?>
<!-- ---------------------------------- -->
<!-- memberitahu ini adalah isi konten di page home -->
<?= $this->section('content'); ?>
<!-- ---------------------------------------------- -->
<div>
    <div class="container pt-4">
        <h1 class="text-center p-4 text-primary-theme">Short URL</h1>
        <div class="row p-4">
            <div class="offset-md-2 col-md-8 border rounded shadow-sm  p-4">
                <?php if (session()->getFlashdata('url') !== null) { ?>
                    <h2 class="text-center">Your Short URL</h2>

                    <div class="input-group mb-3 input-group-lg">
                        <input type="text" class="form-control" id="shortUrl" value="<?= base_url(session()->getFlashdata('url')['slug']) ?>">
                        <!-- <button class="btn btn-success" id="showQrCode" title="QR Code" style="width: 60px;" data-toggle="modal" data-target="#modalQr"><i class="fas fa-qrcode"></i></button> -->
                        <button class="btn btn-success showQr" style="width: 60px;" data-id="<?= session()->getFlashdata('url')['img'] ?>"><i class="fas fa-qrcode"></i></button>
                        <button class="btn btn-primary-theme" id="copyClipboard" data-toggle="tooltip" data-placement="top" title="URL Copied">Copy</button>
                    </div>

                    <p class="break-word px-3"> Long Url : <a href="<?= session()->getFlashdata('url')['fullUrl'] ?>"><?= session()->getFlashdata('url')['fullUrl'] ?></a> </p>

                    <p><a href="<?= base_url() ?>" class="text-theme-primary">Create other URL</a></p>
                <?php
                } else {
                    $validation = \Config\Services::validation();
                ?>

                    <form action="<?= route_to('url.genUrl') ?>" method="post" id="url-add-form">
                        <h2 class="text-center">URL</h2>
                        <?= csrf_field() ?>
                        <!-- Error -->
                        <?php if (session()->getFlashdata('err') !== null) { ?>
                            <div class='alert alert-danger p-2' style="line-height: 1;">
                                <?= $error = session()->getFlashdata('err'); ?>
                            </div>
                        <?php } ?>
                        <div class="input-group mb-3 input-group-lg">
                            <input type="text" class="form-control" id="url" name="url" placeholder="ex. https://www.overclockzone.com">
                            <button class="btn btn-primary-theme" type="submit">Short URL</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
        <?php if(count($listUrl) > 0) { ?>

        <div class="row pt-4">
            <h2 class="text-center text-primary-theme">Top Click URL</h2>

            <div class="col-md-12 tableFixHead">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-uppercase">#</th>
                            <th class="text-uppercase">url</th>
                            <th class="text-uppercase">QR</th>
                            <th class="text-uppercase">full url</th>
                            <th class="text-uppercase">last visit</th>
                            <th class="text-uppercase">Click count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listUrl as $key => $val) {
                        ?>
                            <tr>
                                <td scope="row"><?= $key + 1 ?></td>
                                <td>
                                    <a href="<?= base_url($val['slug']) ?>">
                                        <?= base_url($val['slug']) ?>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-theme-primary showQr" data-id="<?= $val['qr'] ?>"><i class="fas fa-qrcode"></i></button>
                                </td>
                                <td class="break-word" style="max-width: 300px !important;"><?= $val['full_url'] ?></td>
                                <td><?= $val['last_visit_at'] ?  thaidate('j F Y H:i', $val['last_visit_at']) : '-' ?></td>
                                <td class="text-center"><?= $val['count'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalQr" tabindex="-1" role="dialog" aria-labelledby="modalQr" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="imgQr" style="height: 200px;">
            </div>
            <div class="modal-footer">
                <a href="" id="downloadQr" download="QR.jpg" class="btn btn-primary-theme"><i class="fas fa-download"></i> Download</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('extra-js') ?>

<script>
    $(function() {
        $("#copyClipboard").hover(function() {
            $('#copyClipboard').tooltip('hide');
        });
        $('#copyClipboard').click(function() {
            var copyText = document.getElementById("shortUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand('copy');
            $('#copyClipboard').tooltip('show');
        });

        $('.showQr').click(function(){
            
            $('#imgQr').attr('src',$(this).data('id'));
            $('#downloadQr').attr("href", $(this).data('id'));

            $('#modalQr').modal('show');
        })
    });
</script>
<?= $this->endSection() ?>