<?php 
    $logo_url;
    // print_r($t_amount);
    // die;
    

if (empty($org['organisation_logo'])) {
    $logo_url = base_url('images/avatar.png');
} else {
    $logo_url = base_url("uploads/organisation_" . $_SESSION['organisation_id'] . "/logo/" . $org['organisation_logo']);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eFMS | Print</title>
    <link href="<?php echo site_url("myassets/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("myassets/font-awesome/css/font-awesome.css"); ?>" rel="stylesheet">

    <link href="<?php echo site_url("myassets/css/animate.css"); ?>" rel="stylesheet">
    <link href="<?php echo site_url("myassets/css/style.css"); ?>" rel="stylesheet">
    <script src="<?php echo base_url("myassets/js/jquery-3.1.1.min.js"); ?>"></script>
    <script src="<?php echo base_url("myassets/js/bootstrap.js"); ?>"></script>
    <script src="<?php echo base_url("myassets/js/popper.min.js"); ?>"></script>
    <script src="<?php echo site_url("myassets/js/qz-tray.js"); ?>"></script>

    <style type="text/css">
    #invoice-POS {
        box-shadow: 0 0 1in rgba(0, 0, 0, 0.1);
        padding: 8mm;
        margin: 0 auto;
        width: 120mm;
        background: #FFF;}
    </style>
</head>

<body class="white-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="pull-left"><a href="javascript:window.history.go(-1);" class="btn btn-sm btn-primary">
                        <<< Back</a>
                </div>
                <div class="pull-right"><input data-toggle="modal" data-target="#printerModal" type="button" onclick="thermalPrinter()"  value="Print Receipt!" />
                </div>
                <!--  ======================= start print design code =======================-->
                <div id="invoice-POS">

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <img alt="image" style="max-height:35px;max-width:200px;" src="<?php echo $logo_url ?>" />

                            <address>
                                <strong><?php echo $org['name']; ?></strong>
                                <br>
                                <?php echo $branch['branch_name']; ?>
                                <br>
                                <?php echo $branch['physical_address']; ?>

                            </address>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                            <p>
                                <em>Date: <?php echo date('d  F, Y'); ?></em>
                                <br>
                                <abbr title="Phone">Tel:</abbr> <?php echo $branch['office_phone']; ?>
                            </p>
                        </div>
                    </div>
                    <center id="top">
                        <!-- <div class="logo"></div> -->
                        <div class="info">
                            <h3> <?php echo '#'.$trans_id . ' Trans Receipt'; ?> </h3>
                        </div>
                        <!--End Info-->
                    </center>
                    <!--End InvoiceTop-->
                    <div id="bot">
                        <table class="table ">
                            <tbody>
                                
                                <tr>
                                    <td>Amount</td>
                                    <td>
                                        &nbsp;UGX &nbsp;&nbsp; <b>
                                        <?php echo number_format($t_amount);?>
                                        </b>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Date</td>
                                    <td>&nbsp;<?php echo date("d - M - Y, H:m:s", strtotime($date)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Narrative</td>
                                    <td>&nbsp;<?php echo $narrative; ?></td>
                                </tr>
                                
                                
                            </tbody>

                        </table>

                        <div id="legalcopy">
                            <p class="legal"><strong>
                                    <center>Thank you!</center>
                                </strong>
                            </p>
                        </div>

                    </div>
                    <!--End InvoiceBot-->
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $org['name']; ?>
                        </div>
                        <div class="col-md-6 text-right">
                            <small>© <?php echo date('Y'); ?></small>
                        </div>
                    </div>
                </div>
                <!--End Invoice-->
                <!-- =====================================End Print design code =================================-->

            </div>

        </div>

    </div>

  

<!-- Modal -->
<div class="modal fade" id="printerModal" tabindex="-1" role="dialog" aria-labelledby="printerModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Select Printer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <label for="printers">Select Printer</label>
              <div id="loading-printers" class="d-flex justify-content-center align-items-center">
                  <span class="spinner-border mr-2" role="status"></span> fetching printers...
              </div>
              <select class="form-control" name="printers" id="printers">
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="print" type="button" class="btn btn-primary">Print</button>
      </div>
    </div>
  </div>
</div>


    <!-- Bootstrap validator script -->
    <script src="<?php echo base_url("myassets/js/plugins/validate/validator.min.js"); ?>"></script>
    
    <script type="text/javascript">

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
    </script>

    <script>

    // Print to a local thermal printer
    const thermalPrinter = () => {
        const trans_id = "<?php echo '#' . $trans_id . ' Trans Receipt'; ?>";
        const date = "<?php echo $date ?>";
        const t_amount = "<?php echo $t_amount ?>";
        const narrative = "<?php echo $narrative; ?>";
        const transaction_date = '<?php echo date("d - M - Y, H:m:s", strtotime($date)); ?>';
        
        

        let print_data = {
            trans_id,
            transaction_date,
            t_amount,
            narrative,
            org_name: '<?php echo $org['name']; ?>',
            branch_name: '<?php echo $branch['branch_name']; ?>',
            physical_address: '<?php echo $branch['physical_address']; ?>',
            current_date: '<?php echo date('d  F, Y'); ?>',
            office_phone: '<?php echo $branch['office_phone']; ?>',

        };

        $('#printerModal').show();

        qz.websocket.connect().then(() => {
            qz.printers.find().then(printers => {
                printers.forEach(printer => {
                    $('#loading-printers').css('display', 'none').css('visibility', 'hidden');
                    
                    $('#printers').css('display', 'block').css('visibility', 'visible');

                  document.getElementById('printers').innerHTML += `
                <option value="${printer}">${printer}</option>
                `;
                

                });
                
            }).catch(err => console.log(err));
            
        }).catch(err => console.log(err));

    const htmlFormatedData = `<div
        style="width: 219px; display: flex; margin: auto; flex-direction: column; font-size: 12px">
        <div>
            ${print_data.org_name}
        </div>
        <div>
            ${print_data.branch_name} | ${print_data.physical_address}
        </div>
        <div style="margin-bottom: 1em; ">
            Tel : ${print_data.office_phone}
        </div>

        <div>
            <h3 style="margin: 0;">
                <strong>
                    ${print_data.trans_id}
                </strong>
            </h3>
            
        </div>
        <div>
            <small>
                Date : ${print_data.current_date}
            </small>

        </div>

        <hr style="margin: 1em 0; height: 4px">

        <div style="font-weight: bold;">
            
            <div style="display: flex; margin-bottom: 0.5em;">
                <span style="width: 60px;">
                    Principal
                </span>
                <span>: shs. ${print_data.t_amount}</span>
            </div>
            
            
            <div style="display: flex; margin-bottom: 0.5em;">
                <span style="width: 60px;">Date</span>
                <span>: <small>${print_data.transaction_date}</small>
                </span>
            </div>

            <div style="display: flex; margin-bottom: 0.5em;">
                <span style="width: 60px;">Narration</span>
                <span>: ${print_data.narrative}</span>
            </div>

        </div>


        <hr style="margin: 1em 0; height: 4px">

        <div style="display: flex; justify-content: center; margin-bottom: 1em;">
            <strong>
                Thank You.
            </strong>

        </div>

        <div>
            ${print_data.org_name}
        </div>
    </div>`;

        document.getElementById('print').addEventListener('click', () => {
            if(!$('#printers').val()) {
                return;
            }
            const printer = $('#printers').val();

            const config = qz.configs.create(printer);

            qz.print(config, [{
                type: 'pixel',
                format: 'html',
                flavor: 'plain',
                data: htmlFormatedData,
            }]).then(() => {
                $('#printerModal').modal('hide');
                //return qz.websocket.disconnect();
            }).catch(err => console.log(err));
        });       

    }

    $(document).ready(() => {
        $('#printers').css('display', 'none').css('visibility', 'hidden');
    });
    </script>


</body>

</html>