<?php
  use App\Table;
  use App\Chart;
  use PhpOffice\PhpWord\Shared\Converter;

  $section = $phpWord->addSection($sectionAutoFit);

  // Title
  $section->addTitle('1. Broj brojila i čitača po ispostavama', 2);
  $section->addTextBreak();

  $sql = "
    select sifarnik_ispostava.naziv as ispostava,
    sum(dh.broj) as broj_brojila
    , drcl2.brcit as broj_citaca
    from

    (SELECT
            count(hod) as broj, id_citacki_krug
        FROM
            citacki_hod_op
        where aktivan = '1'
        group by id_citacki_krug) as dh

    inner join
    citacki_krug ck on ck.id = dh.id_citacki_krug
    and ck.aktivan = 1

    inner join
    sifarnik_ispostava on sifarnik_ispostava.id = ck.id_sifarnik_ispostava

    inner join
    (select distinct (id_citacki_krug) as id_citacki_krug from r_citacev_listing where id_obracunski_period = $obracunski_period and poslata_lista = '1' and preuzeta_lista is not null and aktivan_za_citanje = '1' and doocitavanje = '0') as drcl on drcl.id_citacki_krug = ck.id

    inner join
    (select
        count(distinct rcl1.id_citac) as brcit, ck1.id_sifarnik_ispostava
    from
        citacki_krug ck1
        inner join
        r_citacev_listing rcl1 ON rcl1.id_citacki_krug = ck1.id
        inner join citac on citac.id = rcl1.id_citac
        and citac.aktivan = 1
    where
        rcl1.id_obracunski_period = $obracunski_period
        and rcl1.poslata_lista = '1'
    	and rcl1.preuzeta_lista is not null
    	and rcl1.doocitavanje = '0'
    	and rcl1.aktivan_za_citanje = '1'
    group by ck1.id_sifarnik_ispostava
    ) as drcl2 on drcl2.id_sifarnik_ispostava = sifarnik_ispostava.id

    group by ck.id_sifarnik_ispostava
  ";

  echo 'pred  upit' . '<br>';
  echo 'upit -> '.$sql.'<br>';
  if ($sqlQuery = mysqli_query($db, $sql)) {
      echo 'u if-u' . '<br>';
      $rows = [];
      $rows[] = ['Ispostava', 'Broj čitača', 'Broj brojila', 'Prosečno brojila po čitaču'];

      $ukupno_citaci_dodeljeno = 0;
      $ukupno_dodeljena_brojila = 0;
      $ukupno_prosecno_brojila_po_citacu = 0;

      $c_ispostave = [];
      $s1_broj_citaca_po_ispostavama = [];
      $s2_broj_brojila_po_ispostavama = [];
      $s3_prosecan_broj_brojila_po_citacu_po_ispostavama = [];

      while ($row = mysqli_fetch_assoc($sqlQuery)) {
          echo 'u while-u' . '<br>';

          $vrednost_ispostava = $row['ispostava'];
          $vrednost_citaci_dodeljeno = $row['broj_citaca'];
          $vrednost_dodeljena_brojila = $row['broj_brojila'];


          $ukupno_citaci_dodeljeno += $vrednost_citaci_dodeljeno;
          $ukupno_dodeljena_brojila += $vrednost_dodeljena_brojila;

          $prosecno_brojila_po_citacu = number_format($vrednost_dodeljena_brojila / $vrednost_citaci_dodeljeno, 2);

          // Charts categories and series
          $c_ispostave[] = $vrednost_ispostava;
          $s1_broj_citaca_po_ispostavama[] = $vrednost_citaci_dodeljeno;
          $s2_broj_brojila_po_ispostavama[] = $vrednost_dodeljena_brojila;
          $s3_prosecan_broj_brojila_po_citacu_po_ispostavama[] = $prosecno_brojila_po_citacu;

          $rows[] = [$vrednost_ispostava, $vrednost_citaci_dodeljeno, $vrednost_dodeljena_brojila, $prosecno_brojila_po_citacu];
      }
      mysqli_free_result($sqlQuery);

      $ukupno_prosecno_brojila_po_citacu = number_format($ukupno_dodeljena_brojila / $ukupno_citaci_dodeljeno, 2);

      $rows[] = ['', '', '', ''];
      $rows[] = ['', '', '', ''];

      $rows[] = [
        ['value' => 'Ukupno', 'bold' => 'true'],
        ['value' => $ukupno_citaci_dodeljeno, 'bold' => true],
        ['value' => $ukupno_dodeljena_brojila, 'bold' => true],
        ['value' => $ukupno_prosecno_brojila_po_citacu, 'bold' => true]
      ];

      // Table
      new Table($rows);

      $section->addTextBreak();

      $section = $phpWord->addSection(array('breakType' => 'continuous'));

      // Charts
      // Broj čitača po ispostavama
      $grafik_broj_citaca_po_ispostavama = new Chart('Broj čitača po ispostavama', Converter::inchToEmu(6.5), Converter::inchToEmu(4), false, true, true);
      $grafik_broj_citaca_po_ispostavama->column($c_ispostave, $s1_broj_citaca_po_ispostavama, 'Broj čitača');

      // Broj brojila po ispostavama
      $grafik_broj_brojila_po_ispostavama = new Chart('Broj brojila po ispostavama', Converter::inchToEmu(6.5), Converter::inchToEmu(4), false, true, true);
      $grafik_broj_brojila_po_ispostavama->column($c_ispostave, $s2_broj_brojila_po_ispostavama, 'Broj brojila');

      // Prosečan broj brojila po čitaču po ispostavama
      $grafik_prosecen_broj_brojila_po_citacu_po_ispostavama = new Chart('Prosečan broj brojila po čitaču po ispostavama', Converter::inchToEmu(6.5), Converter::inchToEmu(4), false, true, true);
      $grafik_prosecen_broj_brojila_po_citacu_po_ispostavama->column($c_ispostave, $s3_prosecan_broj_brojila_po_citacu_po_ispostavama, 'Prosečan broj brojila po čitaču ');
  }
 ?>
