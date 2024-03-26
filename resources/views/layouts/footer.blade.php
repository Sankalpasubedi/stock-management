<!-- jQuery -->
<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{url('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('plugins/moment/moment.min.js')}}"></script>
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('dist/js/pages/dashboard.js')}}"></script>
</body>
<script>
    function payment(event) {
        var conf = confirm('Is the payment done?');
        if (conf === false) {
            event.preventDefault();
            return false;
        }
    }

</script>

<script>
    var pur = document.getElementById('creditPurchaseContent');
    var productDisplay = 0
    if (pur.classList.contains('d-none')) {
        productDisplay = 0
    } else {
        productDisplay = 1
    }

    function purchase() {
        if (productDisplay === 0) {
            pur.classList.remove('d-none');
            document.getElementById('purchase').innerHTML = 'Normal Amount';
            productDisplay = 1;
        } else if (productDisplay === 1) {
            pur.classList.add('d-none');
            document.getElementById('purchase').innerHTML = 'Credit Amount';
            productDisplay = 0;
        }
    }
</script>
{{--<script>--}}
{{--    var sale = document.getElementById('creditSalesContent');--}}
{{--    if (sale.classList.contains('d-none')) {--}}
{{--        var SalesDisplay = 0--}}
{{--    } else {--}}
{{--        var SalesDisplay = 1--}}
{{--    }--}}

{{--    function sales() {--}}
{{--        if (SalesDisplay == 0) {--}}
{{--            sale.classList.remove('d-none');--}}
{{--            document.getElementById('sales').innerHTML = 'Normal Sales';--}}
{{--            SalesDisplay = 1;--}}
{{--        } else if (SalesDisplay == 1) {--}}
{{--            sale.classList.add('d-none');--}}
{{--            document.getElementById('sales').innerHTML = 'Credit Sales';--}}
{{--            SalesDisplay = 0;--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}

<script>
    function addProduct() {
        const itemForm = document.getElementById('copyFrom').cloneNode(true);
        itemForm.classList.remove('d-none');
        const inputs = itemForm.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.value = '';
        });
        const deleteBtn = itemForm.querySelector('.delete');
        deleteBtn.parentNode.classList.remove('d-none');
        document.getElementById('copyTo').appendChild(itemForm);
    }

    function removeProduct(button) {
        const formDiv = button.closest('.item-form');
        const value = formDiv.querySelector('#totalPP').value;
        const totalBillInput = document.getElementById('savedTotal');
        const currentTotal = parseFloat(totalBillInput.value);
        document.getElementById('dButton').checked = false;
        document.getElementById('discountClicked').classList.add("d-none");
        document.getElementById('vet').checked = false;
        document.getElementById('discountAA').value = 0;
        document.getElementById('checkDiscountAmount').value = 0;
        document.getElementById('discountPP').value = 0;
        document.getElementById('checkDiscountPercent').value = 0;
        const totalToAdd = (currentTotal - value);
        document.getElementById('grandTotal').value = totalToAdd;
        totalBillInput.value = totalToAdd;
        formDiv.remove();
    }

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('input', '.price, .stock', updateTotal);

        function updateTotal() {
            var totalBill = 0;

            $('.item-form').each(function () {
                var price = parseFloat($(this).find('.price input').val()) || 0;
                var stock = parseFloat($(this).find('.stock input').val()) || 0;
                var total = price * stock;
                totalBill += total;

                $(this).find('.total input').val(total);
            });

            $('#savedTotal').val(totalBill);
            $('#grandTotal').val(totalBill);
            $('#total').val(totalBill);
        }
    });
</script>

<script>
    const stockInput = document.getElementById('stockPurchase');
    const rateInput = document.getElementById('ratePurchase');
    const totalInput = document.getElementById('totalPurchase');

    function totalCalc() {
        const stock = parseInt(stockInput.value);
        const rate = parseInt(rateInput.value);
        totalInput.value = stock * rate;
    }

    stockInput.addEventListener('input', totalCalc);
    rateInput.addEventListener('input', totalCalc);

</script>
<script>
    window.addEventListener('load', function () {
        const dButton = document.getElementById('dButton');

        function discountT() {
            const discountForDiscount = document.getElementById('dButton');
            if (discountForDiscount.checked) {
                document.getElementById('discountClicked').classList.remove("d-none");
                const percentage = document.getElementById('discountRadioPercent');
                const rupee = document.getElementById('discountRadioRS');
                const percentStats = document.getElementById('discountForPercent');
                const rsStats = document.getElementById('discountForPrice');


                percentage.addEventListener('click', function () {
                    const valueOfTotal = document.getElementById('savedTotal').value;
                    document.getElementById('discountAA').value = 0;
                    document.getElementById('checkDiscountAmount').value = 0;
                    document.getElementById('total').value = valueOfTotal;
                    document.getElementById('discountPP').value = valueOfTotal;
                    const valueOfTotalVatCondition = document.getElementById('vat').value;
                    if (valueOfTotalVatCondition > 0) {
                        vatT()
                    } else {
                        document.getElementById('grandTotal').value = valueOfTotal;
                    }
                    if (percentStats.classList.contains("d-none")) {
                        percentStats.classList.remove("d-none");
                        rsStats.classList.add("d-none");
                    }
                });

                rupee.addEventListener('click', function () {
                    const valueOfTotal = document.getElementById('savedTotal').value;
                    document.getElementById('discountPP').value = 0;
                    document.getElementById('checkDiscountPercent').value = 0;
                    document.getElementById('total').value = valueOfTotal;
                    document.getElementById('discountAA').value = valueOfTotal;
                    const valueOfTotalVatCondition = document.getElementById('vat').value;
                    if (valueOfTotalVatCondition > 0) {
                        vatT()
                    } else {
                        document.getElementById('grandTotal').value = valueOfTotal;
                    }
                    if (rsStats.classList.contains("d-none")) {
                        percentStats.classList.add("d-none");
                        rsStats.classList.remove("d-none");
                    }

                });

            } else {
                document.getElementById('discountPP').value = 0;
                document.getElementById('checkDiscountPercent').value = 0;
                document.getElementById('discountAA').value = 0;
                document.getElementById('checkDiscountAmount').value = 0;
                const savedInput = document.getElementById('savedTotal');
                const saved = parseFloat(savedInput.value);
                const vatCheck = document.getElementById('vat').value;
                document.getElementById('total').value = saved;
                if (vatCheck > 0) {
                    vatT()
                } else {
                    document.getElementById('grandTotal').value = saved;
                }
                document.getElementById('discountClicked').classList.add("d-none");
            }
        }

        dButton.addEventListener('change', discountT);


        document.getElementById('checkDiscountPercent').addEventListener('input', addDiscountPercent);
        document.getElementById('checkDiscountAmount').addEventListener('input', addDiscountAmount);


        function addDiscountPercent() {
            const totalInputBackup = document.getElementById('savedTotal');
            const totalBackup = parseFloat(totalInputBackup.value);
            const totalInput = document.getElementById('grandTotal');
            const total = parseFloat(totalInput.value);
            const totalVatCheckInput = document.getElementById('total');
            const percentInput = document.getElementById('checkDiscountPercent')
            const percent = parseFloat(percentInput.value);
            const disPercent = document.getElementById('discountPP');
            let discountedPrice = totalBackup * (percent / 100);
            if (percent >= 0 && percent <= 100) {
                disPercent.value = discountedPrice;
                totalVatCheckInput.value = (totalBackup - discountedPrice);
                totalInput.value = (totalBackup - discountedPrice);
                const vatCheckInput = document.getElementById('vat');
                const vatCheck = parseFloat(vatCheckInput.value);
                if (vatCheck > 0) {
                    vatT()
                }
            } else {
                alert('Invalid discount');
                totalInput.value = totalBackup
            }
        }

        function addDiscountAmount() {
            const totalInputBackup = document.getElementById('savedTotal');
            const totalBackup = parseFloat(totalInputBackup.value);
            const totalInput = document.getElementById('grandTotal');
            const totalVatCheckInput = document.getElementById('total');
            const amountInput = document.getElementById('checkDiscountAmount')
            const amount = parseFloat(amountInput.value);
            const disAmount = document.getElementById('discountAA');
            const discountedPriceRupee = totalBackup - amount;
            if (amount >= 0 && amount <= totalBackup) {
                disAmount.value = amount;
                totalInput.value = discountedPriceRupee;
                totalVatCheckInput.value = discountedPriceRupee;
                const vatCheckInput = document.getElementById('vat');
                const vatCheck = parseFloat(vatCheckInput.value);
                if (vatCheck > 0) {
                    vatT();
                }
            } else {
                alert('Invalid discount');
                totalInput.value = totalBackup
            }
        }


        const vButton = document.getElementById('vet');

        function vatT() {
            const totalForVat = parseFloat(document.getElementById('total').value);
            const vatInputForVat = document.getElementById('vat');
            const grandForVat = document.getElementById('grandTotal');
            const vatValueForVat = totalForVat * 0.13;
            const vatForVat = document.getElementById('vet');
            if (vatForVat.checked) {
                vatInputForVat.value = vatValueForVat;
                grandForVat.value = totalForVat + (totalForVat * 0.13);
            } else {
                vatInputForVat.value = 0;
                grandForVat.value = totalForVat;
            }
        }

        vButton.addEventListener('change', vatT);
    });
</script>
</html>
