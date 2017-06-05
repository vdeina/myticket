<?php	
namespace app\models;

class ExportExcel
{
    public function  export($tickets,$paymentsAsocArr,$filter_arr,$hide_fees_pegasus)
    {
                require_once('Classes/PHPExcel.php');
          $xls = new \PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $sheet->setTitle('Отчет по продажам');
            $sheet->getRowDimension('1')->setRowHeight(30);
            $sheet->getRowDimension('2')->setRowHeight(25);
            $sheet->getStyle('A2:Z2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('A2:Z2')->getFill()->getStartColor()->setRGB('4CAF50');
            $sheet->mergeCells('A1:Z1');
            $BStyle = array(
          'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Calibri',
                
            )
        );
            $sheet->getStyle('A1')->applyFromArray($BStyle);
          //  $sheet->getStyle('A1')->getAlignment()->setHorizontal(
          //  PHPExcel_Style_Alignment::VERTICAL_CENTER); 
          $sheet->getStyle('A1')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
       
         $sheet->getStyle('A2:Z2')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
        
           
            foreach(range('B','Z') as $columnID)
            {
              $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
         //   $sheet->getColumnDimension('E')->setAutoSize(true);
         // $sheet->getColumnDimension('F')->setWidth(20);
            //for($i=0;$i<14;$i++)
            //{
            //   $sheet->setCellValueByColumnAndRow($i, 4,$i+1);
           // }
              //$sheet->getColumnDimension('A')->setWidth(15);
              $sheet->setCellValue('A2', '№')
                    ->setCellValue('B2', 'Цифровой код АК')
                    ->setCellValue('C2', 'Буквенный код АК')
                    ->setCellValue('D2', ' МЖ/ВН ') 
                    ->setCellValue('E2', 'Маршрут')
                    ->setCellValue('F2', 'Бронь')
                    ->setCellValue('G2', '№ Билета')
                    ->setCellValue('H2', 'Дата продажи')
                    ->setCellValue('I2', 'Статус')
                    ->setCellValue('J2', 'ФИО')
                    ->setCellValue('K2', 'Валюта')
                    ->setCellValue('L2', 'Курс валюты')
                    ->setCellValue('M2', 'Тариф')
                    ->setCellValue('N2', 'Сумма сборов')
                    ->setCellValue('O2', 'Сборы')
                    ->setCellValue('P2', 'Комиссия')
                    ->setCellValue('Q2', 'Агент. сбор')
                    ->setCellValue('R2', 'Скидка')
                    ->setCellValue('S2', 'Всего')
                    ->setCellValue('T2', 'Всего АК')
                    ->setCellValue('U2', 'Имя кассира')
                    ->setCellValue('V2', 'Дата')
                    ->setCellValue('W2', 'Оплата')
                    ->setCellValue('X2', 'Расходы')
                    ->setCellValue('Y2', 'Примечания')
                    ->setCellValue('Z2', 'Метод оплаты')
                    ;
                              
        $BStyle = array(
          'borders' => array(
            'allborders' => array(
             'style' => \PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb'=>'dddddd'
            )
            )
          ),
          'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Calibri',
                'color' => array('rgb' => 'FFFFFF')
            )
        );
        $sheet->getStyle('A2:Z2')->applyFromArray($BStyle);
        $sheet->getStyle('A2:Z2')->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $i=2;
        $count=0;
        $k=3;
        if(count($tickets)>0)
        {
            
       $datesele="";     
       foreach ($tickets as $ticket)
            { 
                if($datesele=="")
                    $datesele =date('d.m.Y',strtotime($ticket['DOCUMENT_ISSUED']));
                
                if($datesele!=date('d.m.Y',strtotime($ticket['DOCUMENT_ISSUED'])))
                {
                  if(array_key_exists($datesele,$paymentsAsocArr))  
                  {
                    $temparr=$paymentsAsocArr[$datesele];
                    foreach($temparr as $payment)
                    {
                       $i++; 
                       if($i%2)
                               $this->cellColor($sheet,'U'.$i.':Z'.$i,"FFFFFF");
                                 else
                               $this->cellColor($sheet,'U'.$i.':Z'.$i,"f2f2f2");
                       $sheet->setCellValue('U'.$i,$payment['name'])
                             ->setCellValue('V'.$i,  date('d.m.Y H:i',strtotime($payment['date'])))
                             ->setCellValue('W'.$i,  $payment['value_pay'])
                             ->setCellValue('X'.$i,  $payment['value_exp'])
                             ->setCellValue('Y'.$i,  $payment['text'])
                             ->setCellValue('Z'.$i,  $payment['method'])
                       ;
                        
                    }
                    unset($paymentsAsocArr[$datesele]);
                    
                  }
                  $datesele =date('d.m.Y',strtotime($ticket['DOCUMENT_ISSUED'])); 
                    
                }
                if($ticket['STATUS']=="REFUNDED")
                    $minus="-";
                else 
                   $minus=""; 
                      $i++;
                      $count++;
                              if($i%2)
                               $this->cellColor($sheet,'A'.$i.':U'.$i,"FFFFFF");
                                 else
                               $this->cellColor($sheet,'A'.$i.':U'.$i,"f2f2f2");
                              $sheet->setCellValue('A'.$i,$count)
                                    ->setCellValue('B'.$i,substr($ticket['DOCUMENT_NUMBER'], 0, 3))
                                    ->setCellValue('C'.$i, $ticket['VALIDATING_CARRIER'])
                                    ->setCellValue('D'.$i, $ticket['DOM_INT']) 
                                    ->setCellValue('E'.$i, " ".$ticket['ROUTE']." ")
                                    ->setCellValue('F'.$i, " ".$ticket['RECORD_LOCATOR']." ")
                                    ->setCellValue('G'.$i, $ticket['DOCUMENT_NUMBER'])
                                    ->setCellValue('H'.$i, date('d.m.Y',strtotime($ticket['DOCUMENT_ISSUED'])))
                                    ->setCellValue('I'.$i, $ticket['STATUS'])
                                    ->setCellValue('J'.$i, $ticket['LAST_NAME']." ".$ticket['FIRST_NAME'])
                                    ->setCellValue('K'.$i, $ticket['CURRENCY'])
                                    ->setCellValue('L'.$i, $ticket['CURRENCY_RATE'])
                                    ->setCellValue('M'.$i, $minus.$ticket['FARE'])
                                    ->setCellValue('N'.$i, $minus.$ticket['TAXES_TOTAL'])
                                    ->setCellValue('O'.$i, $ticket['TAXES'])
                                    ->setCellValue('P'.$i,($hide_fees_pegasus & $ticket['TYPE']=="ПЕГАСУС")?"0":$minus.$ticket['COMMISSION_AMOUNT'])
                                    ->setCellValue('Q'.$i, $ticket['SERVICE_FEE'])
                                    ->setCellValue('R'.$i, $minus.$ticket['DISCOUNT_AMOUNT'])
                                    ->setCellValue('S'.$i, $minus.$ticket['TOTAL'])
                                    ->setCellValue('T'.$i, ($hide_fees_pegasus & $ticket['TYPE']=="ПЕГАСУС")?"0":$minus.$ticket['TOTAL_CAR'])
                                    ->setCellValue('U'.$i, $ticket['name']);
                                    
       }    
       
       if(count($paymentsAsocArr)>0)
       {
        foreach($paymentsAsocArr as $key=>$value)
        {
            foreach($value as $payment)
                    {
                       $i++; 
                       if($i%2)
                               $this->cellColor($sheet,'U'.$i.':Z'.$i,"FFFFFF");
                                 else
                               $this->cellColor($sheet,'U'.$i.':Z'.$i,"f2f2f2");
                       $sheet->setCellValue('U'.$i,$payment['name'])
                             ->setCellValue('V'.$i,  date('d.m.Y H:i',strtotime($payment['date'])))
                             ->setCellValue('W'.$i,  $payment['value_pay'])
                             ->setCellValue('X'.$i,  $payment['value_exp'])
                             ->setCellValue('Y'.$i,  $payment['text'])
                             ->setCellValue('Z'.$i,  $payment['method'])
                       ;
                        
                    }
        }
        
        
       }       
            
              $BStyle1 = array(
                 'borders' => array(
                 'allborders' => array(
                 'style' => \PHPExcel_Style_Border::BORDER_THIN,
                 'color' => array(
                'rgb'=>'ababab'
            )
              )
            ),
            'font'  => array(
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );        
           
           $sheet->getStyle('A3:Z'.$i)->applyFromArray($BStyle1);
           $i+=1;
           $sheet->mergeCells('A'.$i.':L'.$i);
          
          $sheet->getStyle('A'.$k.':Z'.($i-1))->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('J'.$i.':T'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('A'.$i.':I'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);          
            $sheet->setCellValue('A'.$i,"ИТОГО");
           // $sheet->setCellValue('J'.$i,"=SUM(J".$k.":J".($i-1).")");
          //  $sheet->setCellValue('K'.$i,"=SUM(K".$k.":K".($i-1).")");
          //  $sheet->setCellValue('L'.$i,"=SUM(L".$k.":L".($i-1).")");
           // $sheet->setCellValue('M'.$i,"=SUM(M".$k.":M".($i-1).")");
           // $sheet->setCellValue('N'.$i,"=SUM(N".$k.":N".($i-1).")");
            $sheet->setCellValue('P'.$i,"=SUM(P".$k.":P".($i-1).")");
            $sheet->setCellValue('Q'.$i,"=SUM(Q".$k.":Q".($i-1).")");
            $sheet->setCellValue('R'.$i,"=SUM(R".$k.":R".($i-1).")");
            $sheet->setCellValue('S'.$i,"=SUM(S".$k.":S".($i-1).")");
            $sheet->setCellValue('T'.$i,"=SUM(T".$k.":T".($i-1).")");
            $sheet->getStyle('P'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('Q'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('R'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('S'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('T'.$i)->getNumberFormat()->setFormatCode('###');
            //$sheet->setCellValue('T'.($i+1),'=TEXT(24,56;"#.##")');
            
            $BStyle = array(
            'borders' => array(
              'allborders' => array(
              'style' => \PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                'rgb'=>'ababab'
            )
             )
            ),
            'font'  => array(
                  'bold'  => true,
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );
 
         $sheet->getStyle('A'.$i.':Z'.$i)->applyFromArray($BStyle); 
        }
        else
        {
             $sheet->mergeCells('A3:U3');
             $sheet->setCellValue('A3',"не найдено");
        }
         //$sheet->mergeCells('A'.$i.':P'.$i);
        $filename="report_".date('dmY',strtotime(date("Y-m-d"))).".xls";
        if($filter_arr['first_period']=="" && $filter_arr['second_period']=="")
        {
             $filename="report_".date('dmY',strtotime(date("Y-m-01"))).'_'.date('dmY',strtotime(date("Y-m-d"))).".xls";
            $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime(date("Y-m-01")))." - ".date('d.m.Y',strtotime(date("Y-m-d"))));  
        }
        else if($filter_arr['first_period']!="" && $filter_arr['second_period']!="")
        {
             $filename="report_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY',strtotime($filter_arr['second_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime(date($filter_arr['first_period'])))." - ".date('d.m.Y',strtotime($filter_arr['second_period'])));  
        }
        else if($filter_arr['first_period']!="" && $filter_arr['second_period']=="")
        {
           $filename="report_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY',strtotime(date("Y-m-d"))).".xls";
           $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime(date($filter_arr['first_period'])))." - ".date('d.m.Y',strtotime(date("Y-m-d"))));    
        }
        
        
        /* $filename="report_".date('dmY',strtotime($date1)).'_'.date('dmY',strtotime($date2)).".xls";
         header ( "Expires: Mon, 1 Apr 2015 05:00:00 GMT" );
         header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
         header ( "Cache-Control: no-cache, must-revalidate" );
         header ( "Pragma: no-cache" );
         header ( "Content-type: application/vnd.ms-excel" );
         header ( "Content-Disposition: attachment; filename=".$filename );
        
        // Выводим содержимое файла
         $objWriter = new PHPExcel_Writer_Excel5($xls);
         $objWriter->save('php://output');
         */
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($xls, 'Excel5');
        $objWriter->save('php://output');    
         
          exit;
    }
      public function exportAgentsReports($tickets, $filter_arr)
   {
        require_once('Classes/PHPExcel.php');
          $xls = new \PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $sheet->setTitle('Отчет по кассирам');
            $sheet->getRowDimension('1')->setRowHeight(30);
            $sheet->getRowDimension('2')->setRowHeight(25);
            $sheet->getStyle('A2:H2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('A2:H2')->getFill()->getStartColor()->setRGB('4CAF50');
            $sheet->mergeCells('A1:H1');
            $BStyle = array(
          'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Calibri',
                
            )
        );
            $sheet->getStyle('A1')->applyFromArray($BStyle);
          //  $sheet->getStyle('A1')->getAlignment()->setHorizontal(
          //  PHPExcel_Style_Alignment::VERTICAL_CENTER); 
          $sheet->getStyle('A1')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
       
         $sheet->getStyle('A2:H2')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
        
           
            foreach(range('B','H') as $columnID)
            {
              $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
         //   $sheet->getColumnDimension('E')->setAutoSize(true);
         // $sheet->getColumnDimension('F')->setWidth(20);
            //for($i=0;$i<14;$i++)
            //{
            //   $sheet->setCellValueByColumnAndRow($i, 4,$i+1);
           // }
              //$sheet->getColumnDimension('A')->setWidth(15);
              $sheet->setCellValue('A2', '№')
                    ->setCellValue('B2', 'Кассир')
                    ->setCellValue('C2', 'Продажа')
                    ->setCellValue('D2', 'Оплата') 
                    ->setCellValue('E2', 'Сервисный сбор')
                    ->setCellValue('F2', 'Скидка')
                    ->setCellValue('G2', 'Расход')
                    ->setCellValue('H2', 'Долг/Переплата');
                              
        $BStyle = array(
          'borders' => array(
            'allborders' => array(
             'style' => \PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb'=>'dddddd'
            )
            )
          ),
          'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Calibri',
                'color' => array('rgb' => 'FFFFFF')
            )
        );
        $sheet->getStyle('A2:H2')->applyFromArray($BStyle);
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $i=2;
        $count=0;
        $k=3;
        if(count($tickets)>0)
        {
            foreach ($tickets as $ticket)
            { 
                $i++;
                $count++;
                if($i%2)
                    $this->cellColor($sheet,'A'.$i.':H'.$i,"FFFFFF");
                else
                    $this->cellColor($sheet,'A'.$i.':H'.$i,"f2f2f2");
                $sheet->setCellValue('A'.$i,$count)
                    ->setCellValue('B'.$i, $ticket['agent'])
                    ->setCellValue('C'.$i, $ticket['total_ticket'])
                    ->setCellValue('D'.$i, $ticket['payment']) 
                    ->setCellValue('E'.$i, $ticket['service_fee'])
                    ->setCellValue('F'.$i, $ticket['discount'])
                    ->setCellValue('G'.$i, $ticket['expense'])
                    ->setCellValue('H'.$i, "=C$i-D$i-G$i");
                                    
            }           
            
              $BStyle1 = array(
                 'borders' => array(
                 'allborders' => array(
                 'style' => \PHPExcel_Style_Border::BORDER_THIN,
                 'color' => array(
                'rgb'=>'ababab'
            )
              )
            ),
            'font'  => array(
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );        
           
           $sheet->getStyle('A3:H'.$i)->applyFromArray($BStyle1);
           $i+=1;
           $sheet->mergeCells('A'.$i.':B'.$i);
          
          $sheet->getStyle('A'.$k.':H'.($i-1))->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('C'.$i.':H'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('A'.$i.':B'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);          
            $sheet->setCellValue('A'.$i,"ВСЕГО:");
            $sheet->setCellValue('C'.$i,"=SUM(C".$k.":C".($i-1).")");
            $sheet->setCellValue('D'.$i,"=SUM(D".$k.":D".($i-1).")");
            $sheet->setCellValue('E'.$i,"=SUM(E".$k.":E".($i-1).")");
            $sheet->setCellValue('F'.$i,"=SUM(F".$k.":F".($i-1).")");
            $sheet->setCellValue('G'.$i,"=SUM(G".$k.":G".($i-1).")");
            $sheet->setCellValue('H'.$i,"=SUM(H".$k.":H".($i-1).")");
            $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###');
            //$sheet->setCellValue('T'.($i+1),'=TEXT(24,56;"#.##")');
            
            $BStyle = array(
            'borders' => array(
              'allborders' => array(
              'style' => \PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                'rgb'=>'ababab'
            )
             )
            ),
            'font'  => array(
                  'bold'  => true,
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );
 
         $sheet->getStyle('A'.$i.':H'.$i)->applyFromArray($BStyle); 
        }
        else
        {
             $sheet->mergeCells('A3:H3');
             $sheet->setCellValue('A3',"не найдено");
        }
         //$sheet->mergeCells('A'.$i.':P'.$i);
        $filename="report_agents_".date('dmY').".xls";
        $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y'));
        if ($filter_arr['first_period'] != "" && $filter_arr['first_period'] == $filter_arr['second_period'])
        {
            $filename="report_agents_".date('dmY', strtotime($filter_arr['first_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y', strtotime($filter_arr['first_period'])));
        }
        elseif($filter_arr['first_period']!="" && $filter_arr['second_period']!="")
        {
             $filename="report_agents_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY',strtotime($filter_arr['second_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime($filter_arr['first_period']))." - ".date('d.m.Y',strtotime($filter_arr['second_period'])));  
        }
        else if($filter_arr['first_period']!="" && $filter_arr['second_period']=="")
        {
           $filename="report_agents_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY').".xls";
           $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime($filter_arr['first_period']))." - ".date('d.m.Y'));    
        }
        else if($filter_arr['first_period']=="" && $filter_arr['second_period']!="")
        {
            $filename="report_agents_".date('dmY', strtotime($filter_arr['second_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y', strtotime($filter_arr['second_period'])));
        }
        
        
        /* $filename="report_agents_".date('dmY',strtotime($date1)).'_'.date('dmY',strtotime($date2)).".xls";
         header ( "Expires: Mon, 1 Apr 2015 05:00:00 GMT" );
         header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
         header ( "Cache-Control: no-cache, must-revalidate" );
         header ( "Pragma: no-cache" );
         header ( "Content-type: application/vnd.ms-excel" );
         header ( "Content-Disposition: attachment; filename=".$filename );
        
        // Выводим содержимое файла
         $objWriter = new PHPExcel_Writer_Excel5($xls);
         $objWriter->save('php://output');
         */
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($xls, 'Excel5');
        $objWriter->save('php://output');    
         
          exit;
   }
   
        public function exportAviacompaniesReports($tickets, $filter_arr)
   {
        require_once('Classes/PHPExcel.php');
          $xls = new \PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $sheet->setTitle('Отчет по авиакомпаниям');
            $sheet->getRowDimension('1')->setRowHeight(30);
            $sheet->getRowDimension('2')->setRowHeight(25);
            $sheet->getStyle('A2:G2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('A2:G2')->getFill()->getStartColor()->setRGB('4CAF50');
            $sheet->mergeCells('A1:G1');
            $BStyle = array(
          'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Calibri',
                
            )
        );
            $sheet->getStyle('A1')->applyFromArray($BStyle);
          //  $sheet->getStyle('A1')->getAlignment()->setHorizontal(
          //  PHPExcel_Style_Alignment::VERTICAL_CENTER); 
          $sheet->getStyle('A1')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
       
         $sheet->getStyle('A2:G2')->getAlignment()->applyFromArray(
          array(
             'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             'vertical'   => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
             'rotation'   => 0,
             'wrap'       => true
         )
       ); 
        
           
            foreach(range('B','G') as $columnID)
            {
              $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
         //   $sheet->getColumnDimension('E')->setAutoSize(true);
         // $sheet->getColumnDimension('F')->setWidth(20);
            //for($i=0;$i<14;$i++)
            //{
            //   $sheet->setCellValueByColumnAndRow($i, 4,$i+1);
           // }
              //$sheet->getColumnDimension('A')->setWidth(15);
              $sheet->setCellValue('A2', '№')
                    ->setCellValue('B2', 'Авиакомпания')
                    ->setCellValue('C2', 'Продажа')
                    ->setCellValue('D2', 'Комиссия') 
                    ->setCellValue('E2', 'Продажа без комиссии')
                    ->setCellValue('F2', 'Оплата')
                    ->setCellValue('G2', 'Долг/Переплата');
                              
        $BStyle = array(
          'borders' => array(
            'allborders' => array(
             'style' => \PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb'=>'dddddd'
            )
            )
          ),
          'font'  => array(
                'bold'  => true,
                'size'  => 11,
                'name'  => 'Calibri',
                'color' => array('rgb' => 'FFFFFF')
            )
        );
        $sheet->getStyle('A2:G2')->applyFromArray($BStyle);
        $sheet->getStyle('A2:G2')->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $i=2;
        $count=0;
        $k=3;
        if(count($tickets)>0)
        {
            foreach ($tickets as $ticket)
            { 
                $i++;
                $count++;
                if($i%2)
                    $this->cellColor($sheet,'A'.$i.':G'.$i,"FFFFFF");
                else
                    $this->cellColor($sheet,'A'.$i.':G'.$i,"f2f2f2");
                $sheet->setCellValue('A'.$i,$count)
                    ->setCellValue('B'.$i, $ticket['aviacompany'])
                    ->setCellValue('C'.$i, $ticket['total'])
                    ->setCellValue('D'.$i, $ticket['comission']) 
                    ->setCellValue('E'.$i, "=C$i-D$i")
                    ->setCellValue('F'.$i, $ticket['payment'])
                    ->setCellValue('G'.$i, "=E$i-F$i");
                                    
            }           
            
              $BStyle1 = array(
                 'borders' => array(
                 'allborders' => array(
                 'style' => \PHPExcel_Style_Border::BORDER_THIN,
                 'color' => array(
                'rgb'=>'ababab'
            )
              )
            ),
            'font'  => array(
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );        
           
           $sheet->getStyle('A3:G'.$i)->applyFromArray($BStyle1);
           $i+=1;
           $sheet->mergeCells('A'.$i.':B'.$i);
          
          $sheet->getStyle('A'.$k.':G'.($i-1))->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('C'.$i.':G'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
           $sheet->getStyle('A'.$i.':B'.$i)->getAlignment()->setHorizontal(
              \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);          
            $sheet->setCellValue('A'.$i,"ВСЕГО:");
            $sheet->setCellValue('C'.$i,"=SUM(C".$k.":C".($i-1).")");
            $sheet->setCellValue('D'.$i,"=SUM(D".$k.":D".($i-1).")");
            $sheet->setCellValue('E'.$i,"=SUM(E".$k.":E".($i-1).")");
            $sheet->setCellValue('F'.$i,"=SUM(F".$k.":F".($i-1).")");
            $sheet->setCellValue('G'.$i,"=SUM(G".$k.":G".($i-1).")");
            $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('E'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###');
            $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###');
            //$sheet->setCellValue('T'.($i+1),'=TEXT(24,56;"#.##")');
            
            $BStyle = array(
            'borders' => array(
              'allborders' => array(
              'style' => \PHPExcel_Style_Border::BORDER_THIN,
               'color' => array(
                'rgb'=>'ababab'
            )
             )
            ),
            'font'  => array(
                  'bold'  => true,
                  'size'  => 10,
                  'name'  => 'Calibri'
              )
          );
 
         $sheet->getStyle('A'.$i.':G'.$i)->applyFromArray($BStyle); 
        }
        else
        {
             $sheet->mergeCells('A3:G3');
             $sheet->setCellValue('A3',"не найдено");
        }
         //$sheet->mergeCells('A'.$i.':P'.$i);
        $filename="report_aviacompanies_".date('dmY').".xls";
        $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y'));
        if ($filter_arr['first_period'] != "" && $filter_arr['first_period'] == $filter_arr['second_period'])
        {
            $filename="report_aviacompanies_".date('dmY', strtotime($filter_arr['first_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y', strtotime($filter_arr['first_period'])));
        }
        elseif($filter_arr['first_period']!="" && $filter_arr['second_period']!="")
        {
             $filename="report_aviacompanies_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY',strtotime($filter_arr['second_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime($filter_arr['first_period']))." - ".date('d.m.Y',strtotime($filter_arr['second_period'])));  
        }
        else if($filter_arr['first_period']!="" && $filter_arr['second_period']=="")
        {
           $filename="report_aviacompanies_".date('dmY',strtotime($filter_arr['first_period'])).'_'.date('dmY').".xls";
           $sheet->setCellValue('A1', "Отчет за период ".date('d.m.Y',strtotime($filter_arr['first_period']))." - ".date('d.m.Y'));    
        }
        else if($filter_arr['first_period']=="" && $filter_arr['second_period']!="")
        {
            $filename="report_aviacompanies_".date('dmY', strtotime($filter_arr['second_period'])).".xls";
            $sheet->setCellValue('A1', "Отчет за ".date('d.m.Y', strtotime($filter_arr['second_period'])));
        }
        
        
        /* $filename="report_aviacompanies_".date('dmY',strtotime($date1)).'_'.date('dmY',strtotime($date2)).".xls";
         header ( "Expires: Mon, 1 Apr 2015 05:00:00 GMT" );
         header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
         header ( "Cache-Control: no-cache, must-revalidate" );
         header ( "Pragma: no-cache" );
         header ( "Content-type: application/vnd.ms-excel" );
         header ( "Content-Disposition: attachment; filename=".$filename );
        
        // Выводим содержимое файла
         $objWriter = new PHPExcel_Writer_Excel5($xls);
         $objWriter->save('php://output');
         */
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($xls, 'Excel5');
        $objWriter->save('php://output');    
         
          exit;
   }
   
   function cellColor($sheet,$cells,$color){
    $sheet->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
}

?>