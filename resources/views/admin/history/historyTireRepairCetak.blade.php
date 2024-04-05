<x-app-layout>
    <div class="layout-invoice-page">
        <div class="book">
            <button class="btn btn-secondary" onclick="window.print()">Cetak</button>
            <!-- Faktur Retur Penjualan -->
            <div id="template4" class="pbf-fakturretur page position-relative">
                <div class="subpage">
                    <div class="">
                        <table class="report-container w-100">
                            <thead class="report-header">
                                <tr>
                                    <th class="report-header-cell">
                                        <div class="header-content">
                                            <div class="company-details border-0 mb-3">
                                                <p class="fs-6 fw-bold mb-1 text-center">SPARE TYRE</p>
                                                <div class="row px-0 align-items-center justify-content-center">
                                                    <!-- <div class="col py-1">
                                                        <div class="d-block">
                                                            <table class="font-smaller0 w-100 ">
                                                                <tr>
                                                                    <td colspan="3"><p class="fs-6 fw-bold">PT. DWI BIMA PERSADA</p></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"><p class="lh-sm fw-bold">JL. MT. Haryono No. 06 RT. 11 Damai Baru Balikpapan Selatan <br> Kota Balikpapan Prov. Kalimantan Timur 76114</p></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="d-flex" colspan="3">
                                                                        <p class="mb-0 me-2">Telpon : (0542) 878086</p>
                                                                        <p class="mb-0">Fax : 878068</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-3 d-flex position-relative py-1 text-right">
                                                        <table class="font-smaller0 w-100 ">
                                                            <tr>
                                                                <td width="8%" class="fw-bold">Site</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">SITE BSL KM18</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="8%" class="fw-bold">Unit</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">1581</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-4 d-flex position-relative py-1">
                                                        <table class="font-smaller0 w-100 ">
                                                            <tr>
                                                                <td width="25%" class="fw-bold">Driver</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">ANGGA</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="25%" class="fw-bold">Serial Number</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">D3L1A0678</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="report-content">
                                <tr>
                                    <td class="report-content-cell">
                                        <div class="main-content">
                                            <div class="page-details border-0 position-relative" style="bottom: 2px;">
                                                <div class="row justify-content-between px-2">
                                                    <div class="col-4 py-1" style="border: 1px solid black">
                                                        <div class="d-block">
                                                            <table class="font-smaller0 w-100 ">
                                                                <tr>
                                                                    <td width="45%" class="fw-bold">KM Unit</td>
                                                                    <td width="10px">:</td>
                                                                    <td>48412 </td>
                                                                </tr>
                                                                <tr class="v-top">
                                                                    <td width="45%" class="fw-bold">Position</td>
                                                                    <td width="10px">:</td>
                                                                    <td>48412</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="45%" class="fw-bold">Tire Lifetime HM</td>
                                                                    <td width="10px">:</td>
                                                                    <td>0</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="45%" class="fw-bold">Tire Lifetime KM</td>
                                                                    <td width="10px">:</td>
                                                                    <td>0</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 d-flex position-relative py-1" style="border: 1px solid black; left: -1px;">
                                                        <table class="font-smaller0 w-100 ">
                                                            <tr>
                                                                <td width="20%" class="fw-bold">RTD</td>
                                                                <td width="10px">:</td>
                                                                <td>11</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="fw-bold">Man Power</td>
                                                                <td width="10px">:</td>
                                                                <td>ANTO</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="fw-bold">Reason</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">Tertusuk Besi</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="fw-bold">Tire Damage</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">Foreign Object</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-4 d-flex position-relative py-1" style="border: 1px solid black; left: -2px;">
                                                        <table class="font-smaller0 w-100 ">
                                                            <tr>
                                                                <td width="40%" class="fw-bold">Start Date</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">21/03/2024 19.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="fw-bold">End Date</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">21/03/2024 20.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="fw-bold">PIC</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">Priston</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="fw-bold">Tire Status Update</td>
                                                                <td width="2%">:</td>
                                                                <td width="40%">SPARE</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-details border-0 px-2">
                                                <p class="my-2 font-smaller text-center fw-bold">Foto-foto Dokumentasi</p>
                                                <div class="row">
                                                    <div class="col-4 px-2">
                                                        <table class="font-smaller0 w-100 table-bordered border-dark tb-bordereds">
                                                            <tr class="text-center">
                                                                <th width="50%">Before 1</th>
                                                                <th width="50%">After 1</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0!important;"><img src="https://www.castanet.net/content/2022/12/car-spare-tire-wheel-small-size-replace-jack_p3641948.jpg" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                                <td style="padding: 0!important;"><img src="https://tirehungry.com/wp-content/uploads/2022/01/Are-Spare-Tires-Universal.png" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="font-smaller0 fw-bold"><p class="mb-0 text-center">Keterangan</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-4 px-2">
                                                        <table class="font-smaller0 w-100 table-bordered border-dark tb-bordereds">
                                                            <tr class="text-center">
                                                                <th width="50%">Before 2</th>
                                                                <th width="50%">After 2</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0!important;"><img src="https://www.mrtyre.com/wp-content/uploads/2021/02/spare-tyre-1.jpg" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                                <td style="padding: 0!important;"><img src="https://t4.ftcdn.net/jpg/03/45/64/87/360_F_345648793_ZnuIOqkmifOCCM8YiV58yMgOuVfv4jMU.jpg" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="font-smaller0 fw-bold"><p class="mb-0 text-center">Keterangan</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-4 px-2">
                                                        <table class="font-smaller0 w-100 table-bordered border-dark tb-bordereds">
                                                            <tr class="text-center">
                                                                <th width="50%">Before 3</th>
                                                                <th width="50%">After 3</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0!important;"><img src="https://di-uploads-pod16.dealerinspire.com/samlemanautomotivegroup/uploads/2020/04/Car-Jacked-Up-Changing-Tire-46244007_xl-2015.jpg" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                                <td style="padding: 0!important;"><img src="https://www.carscoops.com/wp-content/uploads/2017/10/Spare-Tire-28129-400x217.jpg" width="100%" style="width:100%; height:120px; margin-bottom:-4px; object-fit: cover;" class="w-100" alt=""></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="font-smaller0 fw-bold"><p class="mb-0 text-center">Keterangan</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                                <td class="font-smaller0"><p class="mb-0">anu</p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="border-0 bg-white row py-1 font-smaller">
                                                    <div class="col-12 mt-3 pt-2" style="border-top: 1px solid black;">
                                                        <p class="font-smaller0">SPARE TYRE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
