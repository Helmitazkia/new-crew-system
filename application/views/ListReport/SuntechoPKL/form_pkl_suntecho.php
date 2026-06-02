<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td, th {
        padding: 5px;
        vertical-align: top;
    }
    .header-title {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        padding-bottom: 10px;
    }
    .col-half {
        width: 50%;
    }
    .font-bold {
        font-weight: bold;
    }
    .mb-10 {
        margin-bottom: 10px;
    }
    ul {
        margin: 0;
        padding-left: 20px;
    }
    p {
        margin-top: 0;
        margin-bottom: 10px;
        text-align: justify;
    }
    .page-break {
        page-break-after: always;
    }
    .signature-box {
        margin-top: 40px;
    }
</style>

<htmlpagefooter name="myFooter">
    <div style="text-align: center; color: black; font-size: 12px; font-style: italic; padding-bottom: 20px;">
        {PAGENO}
    </div>
</htmlpagefooter>
<sethtmlpagefooter name="myFooter" value="on" />

<!-- PAGE 1 -->
<table cellpadding="5" class="page-break">
    <thead>
        <tr>
            <th class="col-half header-title">SEAFARER'S EMPLOYMENT AGREEMENT</th>
            <th class="col-half header-title" style="font-style: italic;">PERJANJIAN KERJA PERORANGAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p>This Individual Working Contract, being enclosure and part of the Agreement signed between KESATUAN PELAUT INDONESIA (KPI) and KESATUAN PELAUT INDONESIA (KPI) dan FINE OCEAN MARINE CO.LTD, BUSAN SOUTH OF KOREA CQ INTEROCEAN SHIPPING and MANNING Pte Ltd, 78A Duxton Road, Singapore 089537 on 26 January 2026.<br>
                made by and between :<br>
                <strong>PT. ANDHINI EKA KARYA SEJAHTERA</strong>, located at MENARA KADIN INDONESIA 20TH FL, JL. H. R. RASUNA SAID BLOK X-5, KAV. 2-3, KUNINGAN, SOUTH JAKARTA (hereinafter referred to as the Manning Agent), on behalf of FINE OCEAN MARINE CO.LTD hereinafter referred to as the COMPANY and</p>
                
                <p><strong><?=$crew->fullname?></strong><br>
                (hereinafter called the seafarer)</p>
                
                <table style="width: 100%; border: none;">
                    <tr><td style="border: none; padding: 2px;">Date of Birth</td><td style="border: none; padding: 2px;">: <?=date('d M Y', strtotime($crew->dob))?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Place of Birth</td><td style="border: none; padding: 2px;">: <?=$crew->pob?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Nationality</td><td style="border: none; padding: 2px;">: <?=$crew->nationality ?: 'INDONESIA'?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Passport No.</td><td style="border: none; padding: 2px;">: <?=$crew->passportno?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Seaman Book No.</td><td style="border: none; padding: 2px;">: <?=$crew->seamanbookno?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Seafarer’s Code No.</td><td style="border: none; padding: 2px;">: <?=$crew->seafarer_code?></td></tr>
                    <tr><td style="border: none; padding: 2px;">KPI Membership No.</td><td style="border: none; padding: 2px;">: -</td></tr>
                    <tr><td style="border: none; padding: 2px;">Home address</td><td style="border: none; padding: 2px;">: <?=$crew->paddress?></td></tr>
                </table>
                <br>
                <p>Whereby the following terms and condition of employment are mutually agreed upon.</p>
                
                <br>
                <p><strong>ARTICLE I : ENGAGEMENT</strong><br>
                The Company will engage the Seafarer in accordance with the Agreement with the KESATUAN PELAUT INDONESIA, its enclosure and amendments (if any), and to be executed with utmost good faith.</p>

                <br>
                <p><strong>ARTICLE II : WAGES AND OVERTIME</strong><br>
                During the period this Seafarer’s Employment agreement, the Seafarer shall be employed by the Company in the capacity of:<br>
                Position : <strong><?=$crew->applyfor?></strong><br>
                Name of Vessel : <strong><?=$crew->vessel_name?></strong><br>
                Basic Wages : US$ <?=number_format($salary->basic, 0, ',', '.')?>,-<br>
                Overtime (Fixed) : US$ <?=number_format($salary->fix, 0, ',', '.')?>,-<br>
                Tanker Allowance : US$ <?=number_format($salary->tanker, 0, ',', '.')?>,-<br>
                Leave Pay : US$ <?=number_format($salary->leave, 0, ',', '.')?>,-<br>
                Total : <strong>US$ <?=number_format($salary->total, 0, ',', '.')?>,-</strong><br>
                in accordance with Annex 2 of the Agreement referred to in Article I above.</p>

                <br>
                <p><strong>ARTICLE III : LEAVE PAY</strong><br>
                The Seafarer covered by an Individual Working Contract shall receive at least three (3) days leave pay a month at the Seafarer’s basic wage rate (without overtime) or a mentioned the agreement.</p>

                <br>
                <p><strong>ARTICLE IV : ALLOTMENT</strong><br>
                1. Each seafarer to whom this Agreement applies shall, if they so wish, file with the Master of the vessel a signed allotment note for a minimum of 80% of the accrued basic wages. The Company shall thereupon arrange a monthly remittance, payable in United States currency or the equivalent, to the person named in the allotment note.<br>
                2. The Company shall thereupon arrange to remit a monthly allotment payable in USD or its equivalent in local currency to the person named in the allotment note.</p>
            </td>
            <td style="font-style: italic;">
                <p>Perjanjian Kerja Perorangan ini, yang merupakan lampiran serta bagian dari perjanjian yang ditandatangani antara<br>
                KESATUAN PELAUT INDONESIA (KPI) dan FINE OCEAN MARINE CO.LTD, BUSAN SOUTH OF KOREA CQ INTEROCEAN SHIPPING and MANNING Pte Ltd, 78A Duxton Road, Singapore 089537 tanggal 26 Januari 2026<br>
                dibuat oleh dan antara: <strong>PT. ANDHINI EKA KARYA SEJAHTERA</strong>, beralamat di MENARA KADIN INDONESIA LT 20, JL. H.R RASUNA SAID BLOK X-5, KAV 2-3 KUNINGAN, JAKARTA SELATAN, (Sebagai Manning Agent) mewakili FINE OCEAN MARINE CO.LTD, beralamat di selanjutnya disebut sebagai PERUSAHAAN, dan</p>

                <p><strong><?=$crew->fullname?></strong><br>
                (dalam hal ini disebut Pelaut)</p>

                <table style="width: 100%; border: none; font-style: italic;">
                    <tr><td style="border: none; padding: 2px;">Tanggal Lahir</td><td style="border: none; padding: 2px;">: <?=date('d M Y', strtotime($crew->dob))?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Tempat Lahir</td><td style="border: none; padding: 2px;">: <?=$crew->pob?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Kebangsaan</td><td style="border: none; padding: 2px;">: <?=$crew->nationality ?: 'INDONESIA'?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Passport No.</td><td style="border: none; padding: 2px;">: <?=$crew->passportno?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Buku Pelaut No.</td><td style="border: none; padding: 2px;">: <?=$crew->seamanbookno?></td></tr>
                    <tr><td style="border: none; padding: 2px;">Kode Pelaut No</td><td style="border: none; padding: 2px;">: <?=$crew->seafarer_code?></td></tr>
                    <tr><td style="border: none; padding: 2px;">No. Anggota KPI</td><td style="border: none; padding: 2px;">: -</td></tr>
                    <tr><td style="border: none; padding: 2px;">Alamat</td><td style="border: none; padding: 2px;">: <?=$crew->paddress?></td></tr>
                </table>
                <p>Dalam hal mana, syarat-syarat serta kondisi pengerjaan berikut telah disepakati.</p>
                <p><strong>PASAL I : PENEMPATAN</strong><br>
                Perusahaan akan mempekerjakan Pelaut sesuai dengan Perjanjian dengan Kesatuan Pelaut Indonesia dengan lampiran-lampiran dan perubahan-perubahan (bila ada), dan akan dilaksanakan dengan itikad yang sebaik-baiknya.</p>

                <br>
                <p><strong>PASAL II : GAJI DAN UPAH LEMBUR</strong><br>
                Selama masa berlakunya Perjanjian Kerja Perorangan ini, Pelaut akan dipekerjakan oleh Perusahaan dalam kedudukan sebagai:<br>
                Posisi : <strong><?=$crew->applyfor?></strong><br>
                Nama kapal : <strong><?=$crew->vessel_name?></strong><br>
                Upah pokok : US$ <?=number_format($salary->basic, 0, ',', '.')?>,-<br>
                Upah lembur Fix : US$ <?=number_format($salary->fix, 0, ',', '.')?>,-<br>
                Tunjangan Kapal Tanker : US$ <?=number_format($salary->tanker, 0, ',', '.')?>,-<br>
                Uang pengganti hari-hari libur : US$ <?=number_format($salary->leave, 0, ',', '.')?>,-<br>
                Total : <strong>US$ <?=number_format($salary->total, 0, ',', '.')?>,-</strong><br>
                sesuai dengan Lampiran 2 Perjanjian yang disebut dalam Pasal I diatas.</p>

                <br>
                <p><strong>PASAL III : UANG PENGGANTI HARI-HARI LIBUR</strong><br>
                Pelaut yang bekerja berdasarkan Perjanjian Kerja Perorangan ini akan menerima uang pengganti hari-hari libur paling sedikit 3 (tiga) hari perbulan atas dasar gaji pokok yang berlaku atau seperti dalam perjanjian.</p>

                <br>
                <p><strong>PASAL IV : UANG DELEGASI</strong><br>
                1. Pelaut yang dilindungi oleh Perjanjian Kerja ini, apabila menghendaki, wajib menyampaikan kepada Nakhoda kapal suatu nota pendelegasian yang telah ditandatangani dengan jumlah sekurang-kurangnya 80% (delapan puluh persen) dari upah pokok yang telah diperoleh. Selanjutnya, Perusahaan akan mengatur pengiriman pembayaran setiap bulan, dalam mata uang Dolar Amerika Serikat atau nilai yang setara, kepada pihak yang disebutkan dalam nota pendelegasian tersebut.<br>
                2. Perusahaan selanjutnya akan mengatur untuk mengirimkan alokasi gaji bulanan yang dibayarkan dalam USD atau yang setara dalam mata uang lokal kepada orang yang namanya tercantum dalam surat alokasi (allotment note).</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 2 -->
<table cellpadding="5" class="page-break">
    <tbody>
        <tr>
            <td class="col-half">
                <br>
                <p><strong>ARTICLE V : HOURS OF DUTY</strong><br>
                <strong>1. Day Worker</strong><br>
                The hour of work day worker shall be 8 (eight) hours per day Monday through Friday preferably between 8 AM to 5 PM, and 4 (four) hours per day on Saturday between 8 AM to 12 Noon.</p>
                <br>  
                <p><strong>2. Regular Watch. Deck Department and Engine Department</strong><br>
                In port, crewmember of these departments shall stand their regular watches as required by the Master of the vessel. Overtime rate shall apply for watches stood of work performed in port on Saturday afternoon, Sunday and Holidays.<br>
                At sea, crew member of there departments shall stand their regular watches as required the Master of the vessel</p>
                <br>
                <p><strong>Catering Department</strong><br>
                The working hours of Catering Department members shall be 8 (eight) hours each day in a spread preferably between 6 AM to 7 PM. When the crewmembers of the Catering Department are on day work, the hours of work shall preferably between 8 AM to 12 Noon and 1 PM to 5 PM.</p>
                <br>  
                <p><strong>ARTICLE VI : EXCESS BAGGAGE</strong><br>
                While traveling to or from a vessel under this Individual Working Contract, the Seafarer shall be responsible for any expenses caused by excess baggage beyond the limitation imposed by the Transportation Company used for travel.</p>
                <br>  
                <p><strong>ARTICLE VII : DISCIPLINE</strong><br>
                1. The seafarer, while employed on board a vessel of the Company, shall comply with all lawful orders of his superiors and division heads and will obey all Company’s rule. Recognizing the necessity for discipline on board Company vessel and at the same time in order to protect a Seafarer against unfair treatment, the Company agrees to post on the bulletin board of each vessel a list of rules which shall constitute reason for which Seafarer may be discharge without further notice. Such rules shall be written in such a way to enable the Seafarer to understand.<br>
                2. For other offence not on the posted list, Seafarer shall not be discharge without first having been notified in writing that a repetition on the offence will make him liable to dismissal.</p>
                <br>  
                <p><strong>ARTICLE VIII : TRANSPORTATION AND WAGES UPON TERMINATION</strong><br>
                On termination of employment, the Seafarer shall be paid for our provided with transportation of kind class, as determined by the Company, to return to the place where he has been employed/place of engagement (if immigration laws permitting), or to the airport or seaport nearest the Seafarer’s home, to be determined by the Company in its sole discretion, and he shall be paid his wages (not to include overtime or travel time) up to and including his arrival in Jakarta.</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <br>
                <p><strong>PASAL V : JAM KERJA</strong><br>
                <strong>1. Pekerjaan Harian</strong><br>
                Jam kerja bagi pekerja harian adalah 8 (delapan) jam sehari dimulai Senin sampai dengan Jumat, sebaiknya antara 8 pagi sampai jam 5 sore, dan 4 (empat) jam sehari pada hari Sabtu yang sebaiknya antara jam 8 pagi sampai jam 12 tengah hari</p>
                <br>  
                <p><strong>2. Jaga Biasa</strong><br>
                <strong>Bagian Deck dan Bagian Mesin</strong><br>
                Dipelabuhan awak kapal wajib menjalankan tugas jaga biasa sesuai perintah Nakhoda kapal. Upah lembur akan diberlakukan untuk jaga yang dilakukan atau pekerjaan yang dilaksanakan dipelabuhan pada hari Sabtu sesudah Tengah hari, pada hari Minggu dan Hari Raya Resmi.<br>
                Dilaut, awak kapal bagian ini wajib menjalankan tugas jaga biasa sesuai perintah Nakhoda kapal.</p>
                <br>
                <p><strong>Bagian Pelayanan</strong><br>
                Jam kerja awak kapal bagian pelayanan Adalah 8 (delapan) jam sehari sebagiknya direntang antara jam 6 pagi sampai jam 7 sore. Bila awak kapal bagian pelayanan bekerja harian, jam kerja sebaiknya Adalah jam 8 pagi sampai jam 12 tengah hari dan jam 1 siang sampai jam 5 sore.</p>
                <br>
                <p><strong>PASAL VI: KELEBIHAN BARANG BAWAAN</strong><br>
                Ketika dalam perjalanan ke atau dari kapal dibawah Perjanjian Kerja Perorangan ini, Pelaut harus bertanggung jawab atas biaya yang timbul karena kelebihan barang bawaan diatas batas ketentuan yang ditetapkan oleh Perusahaan Pengangkutan yang dipergunakan untuk melakukan perjalanan.</p>
                <br>
                <p><strong>PASAL VII: DISIPLIN</strong><br>
                1. Pelaut selama dipekerjakan diatas kapal milik Perusahaan, wajib mentaati setiap perintah yang sah dari atasannya dan kepala bagiannya serta akan mentaati peraturan Perusahaan. Mengakui pentingnya disiplin diatas kapal milik Perusahaan pada saat yang sama demi melindungi Pelaut terhadap tindakan yang tidak adil. Perusahaan setuju untuk menempelkan dikapal suatu peraturan yang menetapkan pemberitahuan pendahuluan. Peraturan semacam ini harus tertulis sedemikian rupa sehingga memungkinkah bagi Pelaut untuk dapat dimengerti.<br>
                2. Untuk pelanggaran lain yang tidak dimuat didalam daftar, Pelaut tidak akan dipecat tanpa sebelumnya diberitahu secara tertulis bahwa pengulangan pelanggaran tersebut akan membuatnya dapat dipecat.</p>
                <br>
                <p><strong>PASAL VIII : TRANSPORTASI DAN UPAH PADA SAAT PEMUTUSAN HUBUNGAN KERJA</strong><br>
                Pada saat pemutusan hubungan kerja, Pelaut akan dibayarkan atau diberikan sarana angkutan sesuai jenis dan kelas yang ditentukan oleh Perusahaan, untuk kembali ketempat dimana dia diterima untuk dipekerjakan (bila peraturan keimigrasian mengijinkan) atau Bandar udara atau pelabuhan laut terdekat dari tempat tinggal Pelaut sesuai yang ditentukan Perusahaan, dan kepadanya akan dibayarkan upahnya (tidak termasuk upah lembur atau waktu perjalanan), sampai dengan tanggal tiba di bandar udara atau pelabuhan terdekat.</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 3 -->
<table cellpadding="5" class="page-break">
    <tbody>
        <tr>
            <td class="col-half">
                <br>
                <p><strong>ARTICLE IX : REPATRIATION/EMBARKATION</strong><br>
                1. Repatriation shall take place in such a manner that it meets the needs and reasonable requirements for comfort of the seafarer. The Company shall be liable for the cost of maintaining the seafarer ashore until repatriation takes place.<br>
                2. A seafarer shall be entitled to repatriation at the Company’s expense (including basic wages, subsistence allowance, the cost of accommodation and food, and transport of the seafarer’s personal effects not less than 30 kgs either to her/his home or to the place of her/his original engagement (at the seafarer’s option);<br>
                a. after completion of the Employment Contracts.<br>
                b. when signing off owing to sickness or injury,<br>
                c. when her/his employment is terminated owing to discharge by the Company,<br>
                d. upon the loss and laying-up or sale of the ship,<br>
                e. if the ship has been arrested,<br>
                f. if the Company fails to abide by the terms and conditions of the Agreement, the seafarer is entitled to claim the outstanding wages and to be repatriated at the Company's expense,<br>
                g. on discharge according to Article 27 CBA.<br>
                3. When, during the course of a voyage it is confirmed that the spouse or, in the case of a single person, a parent, has fallen dangerously ill. This provision shall also be applied with regard to the partner of a seafarer provided that this partner has been nominated by the seafarer at the time of engagement as the seafarer’s next of kin, after making reasonable effort by the Company.</p>
                <br>  
                <p><strong>ARTICLE X : COMPENSATION</strong><br>
                <strong>1. Crew’s Effects</strong><br>
                a. When any seafarer suffers total or partial loss or damage to their personal effect and loss of cash, whilst serving on board the ship as a result of wreck, stranding or abandonment of the vessel or as a result of fire, flooding or collision, excluding any loss or damage caused by the seafarer’s own fault or through theft or misappropriation, they shall be entitled to receive from the company a compensation up to a maximum of US$3.021 (three thousand twenty one) for personal effects, including cash of up to US$300 (three hundred) as referred to in ANNEX 3 CBA.<br>
                b. The seafarer shall certify that any information provided, with regard to lost property is true to the best of their knowledge Accident</p>
                <br>
                <p><strong>2. Disability</strong><br>
                a. Any seafarer who suffers injury as a result of an accident from any cause whatsoever whilst in the employment of the Company or arising from their employment with the Company, regardless of fault including accidents occurring while travelling to or from the ship, and whose ability to work as a seafarer is reduced as a result thereof shall, in addition to sick pay, be entitled to compensation according to the provisions of this Agreement.<br>
                b. The disability suffered by the seafarer shall be determined by a company appointed doctor. If a doctor appointed by or on behalf of the seafarer disagrees with the assessment, a third doctor shall be nominated jointly</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <br>
                <p><strong>PASAL IX : PEMULANGAN/EMBARKASI</strong><br>
                1. Pemulangan harus dilakukan sedemikian rupa sehingga memenuhi kebutuhan dan persyaratan yang wajar demi kenyamanan awak kapal. Perusahaan bertanggung jawab atas biaya penanganan awak kapal di darat sampai pemulangan dilakukan.<br>
                2. Pelaut berhak atas pemulangan dari biaya Perusahaan (termasuk gaji pokok, tunjangan subsisten, biaya akomodasi dan makanan, dan pengangkutan barang-barang milik pribadi pelaut tidak kurang dari 30 kg baik ke rumahnya atau ke tempat aslinya sesuai pilihan pelaut):<br>
                a. setelah selesainya Kontrak Kerja.<br>
                b. ketika berhenti kerja karena sakit atau cedera,<br>
                c. ketika diilakukan pemutusan hubungan kerja oleh Perusahaan,<br>
                d. pada saat kapal hilang dan kapal tidak dioperasikan sementara waktu atau kapal dijual,<br>
                e. jika kapal ditahan,<br>
                f. Jika Perusahaan gagal untuk mematuhi syarat dan ketentuan Perjanjian, pelaut berhak untuk menuntut upah yang belum dibayar dan berhak dipulangkan atas biaya Perusahaan,<br>
                g. tentang pemberhentian sesuai Pasal 27.<br>
                3. Apabila sewaktu kapal berlayar dipastikan bahwa istri atau suami pelaut sakit parah atau dalam hal pelaut berstatus lajang, orang tuanya sakit parah. Ketentuan ini juga berlaku terhadap pasangan pelaut dengan ketentuan bahwa pasangan tersebut telah dicalonkan oleh pelaut pada saat pertunangan sebagai keluarga terdekat, setelah dilakukan upaya yang wajar oleh Perusahaan.</p>
                <br>
                <p><strong>PASAL X : PERTANGGUNGAN</strong><br>
                <strong>1. Barang Pribadi Milik Awak Kapal</strong><br>
                a. Ketika seorang awak kapal menderita kehilangan atau kerusakan total atau sebagian terhadap barang pribadinya dan kehilangan uang tunai ketika bertugas di atas kapal yang disebakan oleh kapal karam, terdampar atau ditinggalkan atau akibat kebakaran, banjir atau tabrakan, tidak termasuk setiap kerugian atau kerusakan yang disebabkan oleh kesalahan awak kapal sendiri atau karena pencurian atau penyelewengan, mereka berhak menerima ganti rugi dari perusahaan maksimal sebesar US$3.021 (tiga ribu dua puluh satu USD) untuk barang-barang bawaan milik pribadi pelaut, termasuk uang tunai maksimal sebesar US$300 (tiga ratus USD) sebagaimana dimaksud dalam Lampiran 3 CBA.<br>
                b. Pelaut harus menyatakan bahwa setiap informasi yang diberikan sehubungan dengan harta benda yang hilang adalah benar sepanjang pengetahuan mereka.</p>
                <br>
                <p><strong>2. Disabilitas</strong><br>
                a. Pelaut yang mengalami cedera akibat kecelakaan karena sebab apapun ketika bekerja di Perusahaan atau yang timbul dari pekerjaan mereka di Perusahaan, terlepas dari kesalahannya termasuk kecelakaan yang terjadi selama perjalanan ke kapal atau dari kapal, dan menyebabkan kemampuan kerjanya sebagai pelaut berkurang sebagai akibat dari kecelakaan, selain upah sakit, berhak atas kompensasi sesuai dengan ketentuan - ketentuan dalam Perjanjian ini.<br>
                b. Disabilitas yang diderita oleh pelaut harus ditentukan oleh dokter yang ditunjuk oleh perusahaan. Apabila dokter yang ditunjuk oleh atau atas nama pelaut tidak setuju dengan penilaian tersebut, maka dokter ketiga akan diusulkan secara</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 4 -->
<table cellpadding="5" class="page-break">
    <tbody>
        <tr>
            <td class="col-half">
                <p>between the Company the Union and/or the Seafarer, the decision of this doctor shall be final and binding on both parties. The Company shall provide disability compensation to the Seafarer in accordance with the percentage below:</p>
                <table style="width: 100%; font-size: 10px;">
                    <tr><td>Comps x percent</td><td></td></tr>
                    <tr><td>Loss of one arm</td><td>40%</td></tr>
                    <tr><td>Loss of two arms</td><td>100%</td></tr>
                    <tr><td>Loss of one palm</td><td>35%</td></tr>
                    <tr><td>Loss of two palm</td><td>80%</td></tr>
                    <tr><td>Loss of one leg from the thigh</td><td>40%</td></tr>
                    <tr><td>Loss of two legs from the thigh</td><td>100%</td></tr>
                    <tr><td>Loss of one foot</td><td>35%</td></tr>
                    <tr><td>Loss of two foots</td><td>80%</td></tr>
                    <tr><td>Loss of one eye</td><td>30%</td></tr>
                    <tr><td>Loss of two eyes</td><td>100%</td></tr>
                    <tr><td>Loss hearing of one ear</td><td>15%</td></tr>
                    <tr><td>Loss hearing of two ears</td><td>40%</td></tr>
                    <tr><td>Loss of one finger</td><td>10%</td></tr>
                    <tr><td>Loss of one toe</td><td>5%</td></tr>
                </table>

                <p>c. Any seafarer whose suffers disability, who is assessed at 50% or more be regarded as permanently unfit for further sea service in any capacity and be entitled to 100% compensation. Furthermore, any seafarer assessed at less than 50% disability but certified as permanently unfit for sea service by a company doctor or by a doctor appointed jointly by the Company the Union and/or the seafarer shall also be entitled to 100% compensation.<br>
                d. Any payment effected under this Article 20 shall be without prejudice to any claim for compensation made in law.</p>

                <br>
                <p><strong>3. Lost of Life/Death in Service</strong><br>
                a. If a Seafarer dies through any cause, whilst in the employment of the Company, or arising from her/his employment with the Company, including death from natural causes or death occurring whilst travelling to or from the vessel, or as a result of marine or other similar peril, the Company shall pay the compensation, to the seafarers lawful next of kin in the amount of US$ 60,000,- (sixty thousand US Dollar) for Officer and US$ 40,000,- (forty thousand US Dollar) for Rating, plus US$ 8,000,- (eight thousand US Dollar) for each dependent child under the age of 18 years but not exceeding 3 (three) children. The Company shall also, where practical, and at its own cost, transport the body to the Seafarer’s home and pay the cost of burial expenses.<br>
                b. Any payment effected under this clause shall be without prejudice to any claim for compensation made in law.</p>

                <br>
                <p><strong>ARTICLE XI: PERSONAL PROTECTIVE EQUIPMENT</strong><br>
                1. The Company shall provide all necessary personal protective equipment (in accordance with ISM/IMO regulations, national laws, or equivalent international standards) to ensure adequate protection for all seafarers exposed to risks arising from vessel operations.<br>
                2. Such equipment shall include, but not be limited to:</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <p>bersama -sama antara Perusahaan, Serikat Pekerja dan/atau Pelaut, keputusan dokter ini bersifat final dan mengikat kedua belah pihak. Perusahaan akan memberikan kompensasi cacat kepada Pelaut sesuai dengan persentase yang ditentukan dalam Lampiran 4 berikut.</p>
                <table style="width: 100%; font-size: 10px; font-style: italic;">
                    <tr><td>Kompensasi x persen</td><td></td></tr>
                    <tr><td>Kehilangan satu lengan</td><td>40%</td></tr>
                    <tr><td>Kehilangan kedua lengan</td><td>100%</td></tr>
                    <tr><td>Kehilangan satu telapak tangan</td><td>35%</td></tr>
                    <tr><td>Kehilangan kedua telapak tangan</td><td>80%</td></tr>
                    <tr><td>Kehilangan satu kaki dari paha</td><td>40%</td></tr>
                    <tr><td>Kehilangan kedua kaki dari paha</td><td>100%</td></tr>
                    <tr><td>Kehilangan satu kaki</td><td>35%</td></tr>
                    <tr><td>Kehilangan kedua kaki</td><td>80%</td></tr>
                    <tr><td>Kehilangan satu mata</td><td>30%</td></tr>
                    <tr><td>Kehilangan kedua mata</td><td>100%</td></tr>
                    <tr><td>Kehilangan pendengaran satu telinga</td><td>15%</td></tr>
                    <tr><td>Kehilangan pendengaran kedua telinga</td><td>40%</td></tr>
                    <tr><td>Kehilangan kedua jari tangan</td><td>10%</td></tr>
                    <tr><td>Kehilangan kedua jari kaki</td><td>5%</td></tr>
                </table>

                <p>c. Pelaut yang menderita kecacatan, yang dinilai tingkat kecatatannya 50% atau lebih akan dianggap dalam kapasitas apapun tidak layak secara permanen untuk bekerja dikapal lebih lanjut dan berhak atas 100% kompensasi. Selain itu, setiap pelaut yang dinilai tingkat kecacatannya kurang dari 50% tetapi dinyatakan tidak sehat atau tidak layak bekerja di atas kapal secara permanen oleh dokter perusahaan atau oleh dokter yang ditunjuk bersama oleh Perusahaan, Serikat Pekerja dan/atau pelaut juga berhak atas kompensasi 100%.<br>
                d. Pembayaran yang dilakukan berdasarkan Pasal ini ini tidak mengurangi tuntutan kompensasi yang dibuat berdasarkan hukum.</p>

                <br>
                <p><strong>3. Kehilangan Nyawa/Meninggal Dalam Tugas</strong><br>
                a. Jika seorang Pelaut meninggal karena sebab apapun, saat bekerja di Perusahaan, atau yang timbul dari pekerjaannya di Perusahaan, termasuk kematian karena sebab alamiah atau kematian yang terjadi saat dalam perjalanan ke kapal atau dari kapal, atau akibat kecelakaan laut. atau bahaya serupa lainnya, Perusahaan harus membayar kompensasi, kepada keluarga terdekat sebagai ahli waris yang sah, sebesar US$ 60,000,- (enam puluh ribu US Dollar) untuk Perwira dan US$ 40,000,- (empat puluh ribu US Dollar) Untuk Rating, ditambah US$ 8,000,- (delapan ribu US Dollar) untuk setiap tanggungan anak dibawah umur 18 tahun tetapi tidak melebihi 3 (tiga) orang anak. Perusahaan juga jika memungkinkan dan atas biaya perusahaan sendiri, mengangkut jenazah tersebut ke rumah Pelaut dan membayar biaya-biaya penguburan.<br>
                b. Pembayaran yang dilakukan berdasarkan klausul ini tidak mengurangi tuntutan kompensasi yang dibuat berdasarkan hukum.</p>

                <br>
                <p><strong>PASAL XI : ALAT PELINDUNG DIRI</strong><br>
                1. Perusahaan wajib menyediakan seluruh peralatan pelindung diri yang diperlukan (sesuai dengan peraturan ISM/IMO, hukum nasional, atau standar internasional yang setara) untuk memastikan perlindungan yang memadai bagi setiap pelaut yang terpapar risiko dari kegiatan operasional kapal.<br>
                2. Peralatan pelindung diri tersebut sekurang-kurangnya mencakup:</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 5 -->
<table cellpadding="5" class="page-break">
    <tbody>
        <tr>
            <td class="col-half">
                <p>a. Safety helmets, overalls, and waterproof reinforced safety boots.<br>
                b. Respiratory, eye, and hearing protection; gloves, welding aprons, safety harnesses, ropes with attachments, and buoyancy aids.<br>
                c. Suitable protective outer clothing for work in extreme weather conditions (cold, heat, rain, snow, sleet, hail, spray, strong winds, or hot and humid climates).<br>
                3. Personal protective equipment shall be used individually, stored in designated spaces, and must comply with approved standards, supported by valid certificates or recognized national/international standards.<br>
                4. Ships shall carry survival suits of appropriate size, meeting IMO standards, sufficient for all crew members.<br>
                5. In cold climates or in areas with temperatures of 15°C or below, the Company shall provide seafarers with winter clothing and equipment, consisting at least of:<br>
                a. Winter overcoat or jacket<br>
                b. Scarf and head cover (or equivalent)<br>
                c. Winter working shoes<br>
                d. Winter working gloves<br>
                e. Winter working clothes<br>
                Such equipment and clothing shall remain the property of the Company.</p>

                <br>
                <p><strong>ARTICLE XII : SERVICE IN WARLIKE OPERATIONS AREA</strong><br>
                1. A warlike operations area or high-risk zone will be determined by one of the following organizations: (1) Lloyds and/or any other Underwriters (2) General Council of British Shipping (GCBS). An updated list of the Warlike Operations areas shall be kept on board the vessels and shall be accessible to the crew.<br>
                2. If the vessel is scheduled to enter a Warlike Operations area, the Seafarer’ shall have the right not to proceed to such area. In this event the Seafarer shall be repatriated at Company’s cost with all benefits accrued until the date of return to their home or the port of engagement.<br>
                3. Any Seafarer entering a Warlike Operations shall be:<br>
                a. entitled to a double compensation for death and/or disability.<br>
                b. entitled to a bonus equal to 100% of the basic wage for the whole duration of the ship’s stay in a Warlike Operations area – subject to a minimum of 5 days’ pay.<br>
                4. Seafarers shall have the right to accept or decline an assignment in a Warlike Operations area without risking or losing their employment or suffering any other detrimental effects.<br>
                5. In case, a seafarer becomes captive or otherwise prevented from sailing as a result of an act of piracy or hijacking, the seafarer’s employment status and entitlements under this Agreement shall continue until the seafarer’s release and thereafter until the seafarer is safely repatriated to his/her home or place of engagement or until all Company’s contractual liabilities end. These continued entitlements shall, in particular, include the payment of full wages and other contractual benefits. The Company shall also make every effort to provide captured seafarers, with extra</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <p>a. Helm keselamatan, baju kerja/overall, dan sepatu boot keselamatan yang tahan air serta diperkuat.<br>
                b. Pelindung pernapasan, mata, dan pendengaran; sarung tangan, celemek las, sabuk pengaman dengan tali dan perlengkapannya, serta alat bantu apung.<br>
                c. Pakaian pelindung luar yang sesuai bagi pelaut yang bekerja di luar ruangan dalam kondisi cuaca ekstrem (dingin, panas, hujan, salju, es, hujan es, cipratan air, angin kencang, atau cuaca panas dan lembab).<br>
                3. Peralatan pelindung diri harus digunakan secara individual, disimpan di tempat khusus, dan wajib memenuhi standar yang berlaku, dengan dukungan sertifikat persetujuan atau standar nasional/internasional yang diakui.<br>
                4. Kapal wajib dilengkapi pakaian penyelamat (survival suit) dengan ukuran yang sesuai dan memenuhi standar IMO, tersedia dalam jumlah cukup untuk seluruh awak kapal.<br>
                5. Di daerah beriklim dingin atau dengan suhu 15°C atau lebih rendah, Perusahaan wajib menyediakan pakaian dan perlengkapan musim dingin bagi pelaut, yang sekurang-kurangnya terdiri dari:<br>
                a. Mantel atau jaket musim dingin<br>
                b. Syal dan penutup kepala (atau setara)<br>
                c. Sepatu kerja musim dingin<br>
                d. Sarung tangan musim dingin<br>
                e. Pakaian kerja musim dingin<br>
                Pakaian dan perlengkapan tersebut tetap menjadi milik Perusahaan.</p>

                <br>
                <p><strong>PASAL XII : LAYANAN DI AREA OPERASI SEPERTI PERANG</strong><br>
                1. Area operasi yang rawan perang atau zona berisiko tinggi ditentukan oleh salah satu organisasi berikut: (1) Lloyds dan/atau Penjamin lainnya (2) Dewan Umum Pelayaran Inggris (General Council of British Shipping (GCBS). Daftar terbaru dari area Operasi Rawan Perang harus disimpan di atas kapal dan harus dapat diakses oleh awak kapal.<br>
                2. Jika kapal dijadwalkan untuk memasuki wilayah Operasi Rawan Perang, Pelaut berhak untuk tidak me lanjutkan perjalanan ke daerah tersebut. Dalam hal ini, Pelaut harus dipulangkan dengan biaya Perusahaan dengan semua tunjangan atau tambahan penghasilan lainnya yang masih harus dibayar hingga tanggal kepulangan ke rumah mereka atau pelabuhan perikatan.<br>
                3. Setiap Pelaut yang memasuki Operasi Rawan Perang akan:<br>
                a. berhak atas kompensasi dua kali lipat untuk kematian dan/atau cacat.<br>
                b. berhak atas bonus sebesar 100% dari gaji pokok selama kapal berada di wilayah Operasi Rawan Perang – dikenakan pembayaran upah minimum 5 hari kerja.<br>
                4. Pelaut berhak untuk menerima atau menolak penugasan di daerah Operasi Rawan Bahaya tanpa berisiko atau kehilangan pekerjaan atau mengalami dampak merugikan lainnya.<br>
                5. Apabila seorang pelaut ditawan atau dicegah berlayar sebagai akibat tindakan perompakan atau pembajakan, status pekerjaan dan hak-hak pelaut berdasarkan Perjanjian ini akan terus berlanjut hingga Pelaut dibebaskan dan setelah itu hingga pelaut dipulangkan dengan selamat ke rumah atau tempat penugasannya atau hingga seluruh kewajiban kontraktual Perusahaan berakhir. Hak-hak yang terus berlanjut ini, khususnya, termasuk pembayaran upah penuh dan tambahan/tunjangan penghasilan kontrak lainnya. Perusahaan juga harus melakukan segala upaya untuk</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 6 -->
<table cellpadding="5" class="page-break">
    <tbody>
        <tr>
            <td class="col-half">
                <p>protection, food, welfare, medical and other assistance as necessary as far as possible.</p>

                <br>
                <p><strong>ARTICLE XIII : DISPUTES</strong><br>
                A disputes or grievance in connection with the terms and provisions of this contract shall be adjusted in accordance with the following procedures :<br>
                1. Any seafarer who feels that he has been unjustly treated or been subjected to any unfair consideration shall endeavor to have said grievance adjusted by the designated representative of the Seafarer abroad the vessel in the following manner :<br>
                a. Presentation of the complain to his immediate superior.<br>
                b. Appeal to the head of the Department in which the employee involved as employed.<br>
                c. Appeal to the Master of the Vessel.<br>
                2. If the grievance cannot be solved under the provisions of paragraph 1, the decision of the Master shall govern at sea and in foreign ports. The disputes shall be referred to the representative of the Union, who, if he believes it has merit, shall attempt to solve it with the local representative of the company.<br>
                The Company reserves the right, where necessary, to its head office for final settlement. Similarly, the representative of the Union reserve the right. Where necessary, to refer a dispute to his National Office for disposition with the head office of the Company. It is understood, however, that this right will be used sparingly and that both parties will make every efforts to settle the disputes in the port where they arrive as amicably as possible.<br>
                3. During the process as mentioned in paragraph 1 and 2 above, the Seafarer shall perform his duties as usual.<br>
                4. To stipulate that any party bound by this agreement shall be prohibited from engaging in any act of discrimination (based on ethnicity, religion, race, or inter-group affiliation), including threats, oppression, or abuse, whether physical or psychological, in any aspect related to work on board the vessel.</p>

                <br>
                <p><strong>ARTICLE XIV: DURATION OF EMPLOYMENT</strong><br>
                A Seafarer shall be engaged for a period of 6 (six) months for senior officers and 9 (nine) months for non-senior officers, and such period(s) may be extended to 7 (seven) months for senior officers and 10 (ten) months for non-senior officers or reduced to 5 (five) months for senior officers and 8 (eight) months for non-senior officers for operational convenience. The employment shall be effective from the date of signing of the Seafarer Employment Agreement and shall be automatically terminated in accordance with the terms of this Agreement at the first arrival of the ship in port after expiration of the applicable period, unless the Company operates a permanent employment system.</p>

                <br>
                <p><strong>ARTICLE XV: EQUALITY</strong><br>
                Each seafarer shall be entitled to work, train and live in an environment free from harassment and bullying whether sexually, racially, or otherwise motivated. The Company will regard breaches of this of this undertaking as a serious act of misconduct on the part of seafarers.</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <p>menyediakan pelaut yang ditangkap, dengan perlindungan ekstra, makanan, kesejahteraan, bantuan medis dan bantuan lain yang diperlukan sejauh mungkin.</p>

                <br>
                <p><strong>PASAL XIII : PERSELISIHAN</strong><br>
                Suatu perselisihan atau keluh kesah yang timbul sehubungan dengan syarat-syarat ketentuan Perjanjian ini harus diselesaikan sesuai dengan tata cara berikut :<br>
                a. Setiap pelaut yang merasa bahwa dirinya diperlakukan kurang adil atau menjadi sasaran pertimbangan yang tidak adil akan berusaha menyelesaikan keluh kesah tersebut melalui wakil Pelaut yang ditunjuk diatas kapal dengan cara sebagai berikut :<br>
                a. Mengajukan masalahnya kepada atasannya langsung.<br>
                b. Mengajukan kepada Kepala Bagiannya dimana yang bersangkutan dipekerjakan.<br>
                c. Mengajukan kepada Nakhoda Kapal.<br>
                b. Bila keluh kesah tak dapat dipecahkan berdasarkan ayat (1), keputusan Nakhoda akan tetap berlaku dilaut dan dipelabuhan asing. Perselisihan kemudian akan diajukan kepada wakil Serikat Buruh, yang bila memungkinkan akan berusaha untuk memecahkannya bersama wakil Perusahaan. Demikian pula Serikat Buruh mempunyai hak, bila perlu, untuk meneruskan perselisihan tersebut kepada kantor pusatnya untuk mempersoalkannya dengan kantor pusat Perusahaan. Harus diingat bahwa hal semacam ini<br>
                Perusahaan tetap memiliki hak, bila perlu untuk meneruskan perselisihan ini ke kantor pusatnya untuk mendapatkan penyelesaian terakhir. bagaimnapun akan dipergunakan bila dianggap perlu, dan bahwa kedua belah pihak akan berusaha untuk menyelesaikan perselisihan dipelabuhan dimana perselisihan timbul dengan cara yang sebaik-baiknya.<br>
                c. Selama porses seperti tersebut dalam paragraph 1 dan 2 diatas. Pelaut harus tetap melaksanakan tugasnya seperti biasa.<br>
                d. Mengatur bahwa siapapun yang terikat dalam perjanjian ini tidak di perbolehkan melakukan tindakan diskriminasi (SARA), termasuk pengancaman, penindasan, dan penganiayaan, baik secara fisik maupun mental dalam segala aspek terkait pekerjaan di atas kapal.</p>

                <br>
                <p><strong>PASAL XIV: MASA KERJA</strong><br>
                Pelaut akan terikat dengan Perusahaan untuk jangka waktu 6 (enam) bulan bagi perwira senior dan 9 (sembilan) bulan bagi perwira non-senior, dan jangka waktu tersebut dapat diperpanjang menjadi 7 (tujuh) bulan bagi perwira senior dan 10 (sepuluh) bulan bagi perwira non-senior atau dikurangi menjadi 5 (lima) bulan bagi perwira senior dan 8 (delapan) bulan bagi perwira non-senior sesuai dengan kebutuhan operasional. Hubungan kerja akan berlaku sejak tanggal penandatanganan Perjanjian Kerja Pelaut dan akan secara otomatis berakhir sesuai ketentuan dalam Perjanjian ini pada saat kapal tiba di pelabuhan pertama setelah berakhirnya jangka waktu kerja tersebut, kecuali Perusahaan memberlakukan sistem kerja tetap.</p>

                <br>
                <p><strong>PASAL XV: KESETARAAN</strong><br>
                Setiap pelaut berhak untuk bekerja, berlatih dan tinggal di lingkungan yang bebas dari pelecehan dan perundungan baik yang bermotif seksual, ras, atau lainnya. Perusahaan akan menganggap pelanggaran terhadap perjanjian ini sebagai tindakan pelanggaran serius/berat yang dilakukan oleh pelaut.</p>
            </td>
        </tr>
    </tbody>
</table>

<!-- PAGE 7 -->
<table cellpadding="5">
    <tbody>
        <tr>
            <td class="col-half">
                <br>
                <p><strong>ARTICLE XVI: EFFECTIVE DATE AND DURATION OF AGREEMENT</strong><br>
                1. Effective date : this contract and all its provision shall take effect on:<br>
                _________________________<br>
                2. Duration : This contract shall continue to be valid until <?= isset($salary->duration_months) ? $salary->duration_months : '2' ?> Month unless terminated by either party upon 30 (thirty) days written notice to the other party.</p>

                <p>In witness of the aforesaid terms and condition both parties sign this contract this day __________________</p>
            </td>
            <td class="col-half" style="font-style: italic;">
                <br>
                <p><strong>PASAL XVI: MULAI BERLAKUNYA DAN JANGKA WAKTU PERJANJIAN</strong><br>
                1. Tanggal berlaku: Perjanjian ini dan semua ketentuan-ketentuannya akan mulai berlaku pada tanggal :<br>
                _____________________<br>
                2. Masa berlaku: Perjanjian ini akan tetap berlaku sampai <?= isset($salary->duration_months) ? $salary->duration_months : '2' ?> Bulan atau diakhiri oleh salah satu pihak dengan pemberitahuan tertulis 30 (tiga puluh) hari sebelumnya kepada pihak yang lain.</p>

                <p>Sebagai kesaksian dari ketentuan dan syarat-syarat diatas, kedua belah pihak menandatangani Perjanjian ini tanggal __________________</p>
            </td>
        </tr>
        <tr>
            <td class="col-half" style="text-align: center;">
                <div class="signature-box" style="margin-bottom: 50px;">
                    <p>THE COMPANY<br>Perusahaan</p>
                    <br><br><br><br>
                    <p>(___EVA MARLIANA___)<br>Head Of Crewing Division</p>
                </div>
            </td>
            <td class="col-half" style="text-align: center;">
                <div class="signature-box" style="margin-bottom: 50px;">
                    <p>THE SEAFARER<br>Pelaut</p>
                    <br><br><br><br>
                    <p>(____<?=$crew->fullname?>___)</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>