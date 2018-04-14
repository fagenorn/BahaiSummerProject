<?php

namespace App\Http\Controllers;

use App\Group;
use App\Participant;
use Barryvdh\DomPDF\Facade as PDF;
use DateInterval;
use DateTime;
use Maatwebsite\Excel\Facades\Excel as Excel;
use TCG\Voyager\Facades\Voyager;

class InvoiceController extends Controller
{
    public function create($id)
    {
        Voyager::canOrFail('read_groups');

        $group = Group::findOrFail($id);
        $pdf = PDF::loadView('invoice', array('group' => $group));
        return $pdf->stream('invoice.pdf');
    }

    public function download()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Groups', function ($excel) {

            // Set the title
            $excel->setTitle('Groups');
            $excel->sheet('Groups', function ($sheet) {
                $sheet->row(1, array(
                    'Last Name', 'Email', 'Phone', 'Participants'
                ));
                $sheet->cells('A1:D1', function ($cells) {
                    $cells->setFontSize(14);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $groups = Group::all();
                for ($i = 1; $i <= count($groups); $i++) {
                    $group = $groups[$i - 1];
                    $sheet->row($i + 1, array(
                        $group->last_name, $group->email, $group->phone, $group->users->map(function ($user) {
                            return $user->last_name . " " . $user->first_name;
                        })->implode(', ')
                    ));
                }
            });

        })->download('xlsx');
    }

    public function downloadAgeLanguage()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Age and Language', function ($excel) {
            $excel->setTitle('Age & Language');

            $excel->sheet('Age & Language', function ($sheet) {
                $languages = [
                    ['text' => 'English', 'prop' => '0'],
                    ['text' => 'Dutch', 'prop' => '1'],
                    ['text' => 'French', 'prop' => '2']
                ];
                $headers = [
                    ['text' => 'Name', 'prop' => 'first_name'],
                    ['text' => 'Surname', 'prop' => 'last_name'],
                    ['text' => 'Gender', 'prop' => 'gender_name']
                ];

                $age_groups = [
                    ['text' => '0 to 3 years', 'min' => 0, 'max' => 3],
                    ['text' => '4 to 10 years', 'min' => 4, 'max' => 10],
                    ['text' => '11 to 15 years', 'min' => 11, 'max' => 15],
                    ['text' => '16 to 30 years', 'min' => 16, 'max' => 30],
                    ['text' => 'Over 30 years', 'min' => 31, 'max' => 999],
                ];

                $tallest = 0;
                $last_col = 'B';
                $participants_all = Participant::all();
                for ($i = 0; $i < sizeof($languages); $i++) {
                    $language = $languages[$i];
                    $participants_language = $participants_all->where('language', $language['prop']);
                    // ord('B') == 66
                    $col = chr(66 + (sizeof($headers) + 1) * $i);
                    $last_col = $col;
                    $row = 2;

                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $header = $headers[$j];
                        $sheet->cell(chr(ord($col) + $j) . $row, function ($cell) use ($header) {
                            $cell->setValue($header['text']);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                    }


                    // Set language
                    $row++;
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . ($row + 1));
                    $sheet->cell($col . $row, function ($cell) use ($language) {
                        $cell->setValue($language['text']);
                        $cell->setFontSize(16);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('medium', 'medium', 'medium', 'medium');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                    });

                    // Create age groups
                    $row++;
                    for ($j = 0; $j < sizeof($age_groups); $j++) {
                        $age_group = $age_groups[$j];
                        $row += 2;
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($age_group) {
                            $cell->setValue($age_group['text']);
                            $cell->setFontSize(13);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });

                        $participants = $participants_language->filter(function ($item) use ($age_group) {
                            return $item->age >= $age_group['min'] && $item->age <= $age_group['max'];
                        });

                        // Add participants
                        for ($k = 0; $k < $participants->count(); $k++) {
                            $row++;
                            $participant = $participants->slice($k, 1)->first();

                            for ($f = 0; $f < sizeof($headers); $f++) {
                                $header = $headers[$f]['prop'];
                                $data = $participant->$header;
                                $sheet->cell(chr(ord($col) + $f) . $row, function ($cell) use ($data) {
                                    $cell->setValue($data);
                                    $cell->setFontSize(12);
                                    $cell->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                            }
                        }

                        // Set total
                        $row++;
                        $size = $participants->count();
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($size) {
                            $cell->setValue('Total: ' . $size);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('thick', 'thin', 'thin', 'thin');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#FCE4D6');
                        });
                    }

                    // Set total
                    $row += 2;
                    $size = $participants_language->count();
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                    $sheet->cell($col . $row, function ($cell) use ($size) {
                        $cell->setValue('Total: ' . $size);
                        $cell->setFontSize(12);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('thick', 'thick', 'thick', 'thick');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBackground('#F8CBAD');
                    });

                    if ($row > $tallest) {
                        $tallest = $row;
                    }

                    // Set column width
                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $sheet->setWidth(chr(ord($col) + $j), 16);
                    }
                }

                // Set total
                $tallest += 2;
                $size = $participants_all->count();
                $sheet->mergeCells('B' . $tallest . ':' . chr(ord($last_col) + sizeof($headers) - 1) . $tallest);
                $sheet->cell('B' . $tallest, function ($cell) use ($size) {
                    $cell->setValue('Total: ' . $size);
                    $cell->setFontSize(14);
                    $cell->setFontWeight('bold');
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#F4B084');
                });
            });
        })->download('xlsx');
    }

    public function downloadDaysDistribution()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Days Distribution', function ($excel) {
            $excel->setTitle('Days Distribution');

            $excel->sheet('Days Distribution', function ($sheet) {
                $headers = [
                    ['text' => 'Name', 'prop' => 'first_name'],
                    ['text' => 'Surname', 'prop' => 'last_name'],
                    ['text' => 'Gender', 'prop' => 'gender_name']
                ];
                $age_groups = [
                    ['text' => '0 to 3 years', 'min' => 0, 'max' => 3],
                    ['text' => '4 to 10 years', 'min' => 4, 'max' => 10],
                    ['text' => '11 to 15 years', 'min' => 11, 'max' => 15],
                    ['text' => '16 to 30 years', 'min' => 16, 'max' => 30],
                    ['text' => 'Over 30 years', 'min' => 31, 'max' => 999],
                ];

                $dates = [];
                $start = new DateTime(\Config::get('constants.start_day'));
                $end = new DateTime(\Config::get('constants.end_day'));
                $done = false;
                while (!$done) {
                    $dates[] = clone $start;
                    $start->add(new DateInterval('P1D'));
                    if ($start > $end) {
                        $done = true;
                    }
                }

                $tallest = 0;
                $last_col = 'B';
                $participants_all = Participant::all();
                for ($i = 0; $i < sizeof($dates); $i++) {
                    $date = $dates[$i];
                    $participants_date = $participants_all->filter(function ($item) use ($date) {
                        return $item->isPresentOnDate($date);
                    });

                    // ord('B') == 66
                    $col = chr(66 + (sizeof($headers) + 1) * $i);
                    $last_col = $col;
                    $row = 2;

                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $header = $headers[$j];
                        $sheet->cell(chr(ord($col) + $j) . $row, function ($cell) use ($header) {
                            $cell->setValue($header['text']);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                    }


                    // Set language
                    $row++;
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . ($row + 1));
                    $sheet->cell($col . $row, function ($cell) use ($date) {
                        $cell->setValue($date->format('d F Y'));
                        $cell->setFontSize(16);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('medium', 'medium', 'medium', 'medium');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                    });

                    // Create age groups
                    $row++;
                    for ($j = 0; $j < sizeof($age_groups); $j++) {
                        $age_group = $age_groups[$j];
                        $row += 2;
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($age_group) {
                            $cell->setValue($age_group['text']);
                            $cell->setFontSize(13);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });

                        $participants = $participants_date->filter(function ($item) use ($age_group) {
                            return $item->age >= $age_group['min'] && $item->age <= $age_group['max'];
                        });

                        // Add participants
                        for ($k = 0; $k < $participants->count(); $k++) {
                            $row++;
                            $participant = $participants->slice($k, 1)->first();

                            for ($f = 0; $f < sizeof($headers); $f++) {
                                $header = $headers[$f]['prop'];
                                $data = $participant->$header;
                                $sheet->cell(chr(ord($col) + $f) . $row, function ($cell) use ($data) {
                                    $cell->setValue($data);
                                    $cell->setFontSize(12);
                                    $cell->setBorder('thin', 'thin', 'thin', 'thin');
                                });
                            }
                        }

                        // Set total
                        $row++;
                        $size = $participants->count();
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($size) {
                            $cell->setValue('Total: ' . $size);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('thick', 'thin', 'thin', 'thin');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#FCE4D6');
                        });
                    }

                    // Set total
                    $row += 2;
                    $size = $participants_date->count();
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                    $sheet->cell($col . $row, function ($cell) use ($size) {
                        $cell->setValue('Total: ' . $size);
                        $cell->setFontSize(12);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('thick', 'thick', 'thick', 'thick');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBackground('#F8CBAD');
                    });

                    if ($row > $tallest) {
                        $tallest = $row;
                    }

                    // Set column width
                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $sheet->setWidth(chr(ord($col) + $j), 16);
                    }
                }

                // Set total
                $tallest += 2;
                $size = $participants_all->count();
                $sheet->mergeCells('B' . $tallest . ':' . chr(ord($last_col) + sizeof($headers) - 1) . $tallest);
                $sheet->cell('B' . $tallest, function ($cell) use ($size) {
                    $cell->setValue('Total: ' . $size);
                    $cell->setFontSize(14);
                    $cell->setFontWeight('bold');
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#F4B084');
                });
            });
        })->download('xlsx');
    }

    public function downloadMeals()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Meals', function ($excel) {
            $excel->setTitle('Meals');

            $excel->sheet('Meals', function ($sheet) {
                $meals = [
                    ['text' => 'Standard', 'prop' => '0'],
                    ['text' => 'Vegetarian', 'prop' => '1'],
                    ['text' => 'Self-catering', 'prop' => '2']
                ];
                $headers = [
                    ['text' => 'Meal Type', 'prop' => ''],
                    ['text' => 'Amount', 'prop' => ''],
                ];
                $age_groups = [
                    ['text' => 'Under 3 years', 'min' => 0, 'max' => 2],
                    ['text' => '3 to 11 years', 'min' => 3, 'max' => 11],
                    ['text' => 'Over 11 years', 'min' => 12, 'max' => 999]
                ];

                $dates = [];
                $start = new DateTime(\Config::get('constants.start_day'));
                $end = new DateTime(\Config::get('constants.end_day'));
                $done = false;
                while (!$done) {
                    $dates[] = clone $start;
                    $start->add(new DateInterval('P1D'));
                    if ($start > $end) {
                        $done = true;
                    }
                }

                $tallest = 0;
                $last_col = 'B';
                $participants_all = Participant::all();
                for ($i = 0; $i < sizeof($dates); $i++) {
                    $date = $dates[$i];
                    $participants_date = $participants_all->filter(function ($item) use ($date) {
                        return $item->isPresentOnDate($date);
                    });

                    // ord('B') == 66
                    $col = chr(66 + (sizeof($headers) + 1) * $i);
                    $last_col = $col;
                    $row = 2;

                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $header = $headers[$j];
                        $sheet->cell(chr(ord($col) + $j) . $row, function ($cell) use ($header) {
                            $cell->setValue($header['text']);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });
                    }


                    // Set day
                    $row++;
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . ($row + 1));
                    $sheet->cell($col . $row, function ($cell) use ($date) {
                        $cell->setValue($date->format('d F Y'));
                        $cell->setFontSize(16);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('medium', 'medium', 'medium', 'medium');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                    });

                    // Create age groups
                    $row++;
                    for ($j = 0; $j < sizeof($age_groups); $j++) {
                        $age_group = $age_groups[$j];
                        $row += 2;
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($age_group) {
                            $cell->setValue($age_group['text']);
                            $cell->setFontSize(13);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('medium', 'medium', 'medium', 'medium');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                        });

                        $participants_age = $participants_date->filter(function ($item) use ($age_group) {
                            return $item->age >= $age_group['min'] && $item->age <= $age_group['max'];
                        });

                        // Add meals
                        for ($k = 0; $k < sizeof($meals); $k++) {
                            $meal = $meals[$k];
                            $row++;
                            $participants_meal = $participants_age->where('diet', $meal['prop']);
                            $size = $participants_meal->count();
                            $name = $meal['text'];
                            $sheet->cell($col . $row, function ($cell) use ($name) {
                                $cell->setValue($name);
                                $cell->setFontSize(12);
                                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                            $sheet->cell(chr(ord($col) + 1) . $row, function ($cell) use ($size) {
                                $cell->setValue($size);
                                $cell->setFontSize(12);
                                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            });
                        }

                        // Set total
                        $row++;
                        $size = $participants_age->count();
                        $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                        $sheet->cell($col . $row, function ($cell) use ($size) {
                            $cell->setValue('Total: ' . $size);
                            $cell->setFontSize(12);
                            $cell->setFontWeight('bold');
                            $cell->setBorder('thick', 'thin', 'thin', 'thin');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#FCE4D6');
                        });
                    }

                    // Set total
                    $row += 2;
                    $size = $participants_date->count();
                    $sheet->mergeCells($col . $row . ':' . chr(ord($col) + sizeof($headers) - 1) . $row);
                    $sheet->cell($col . $row, function ($cell) use ($size) {
                        $cell->setValue('Total: ' . $size);
                        $cell->setFontSize(12);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('thick', 'thick', 'thick', 'thick');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBackground('#F8CBAD');
                    });

                    if ($row > $tallest) {
                        $tallest = $row;
                    }

                    // Set column width
                    for ($j = 0; $j < sizeof($headers); $j++) {
                        $sheet->setWidth(chr(ord($col) + $j), 16);
                    }
                }

                // Set total
                $tallest += 2;
                $size = $participants_all->count();
                $sheet->mergeCells('B' . $tallest . ':' . chr(ord($last_col) + sizeof($headers) - 1) . $tallest);
                $sheet->cell('B' . $tallest, function ($cell) use ($size) {
                    $cell->setValue('Total: ' . $size);
                    $cell->setFontSize(14);
                    $cell->setFontWeight('bold');
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#F4B084');
                });
            });
        })->download('xlsx');
    }

    public function downloadPayments()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Payments', function ($excel) {
            $excel->setTitle('Payments');

            $excel->sheet('Payments', function ($sheet) {
                $headers = [
                    ['text' => 'Last Name', 'prop' => 'last_name'],
                    ['text' => 'Email', 'prop' => 'email'],
                    ['text' => 'Phone', 'prop' => 'phone'],
                    ['text' => 'Amount Paid', 'prop' => 'paid'],
                    ['text' => 'Reductions', 'prop' => 'reduction'],
                    ['text' => 'Due', 'prop' => 'due_price'],
                    ['text' => 'Status', 'prop' => ''],
                ];

                $col = 'B';
                $row = 2;

                // Generate headers
                for ($i = 0; $i < sizeof($headers); $i++) {
                    $header = $headers[$i];
                    $sheet->cell(chr(ord($col) + $i) . $row, function ($cell) use ($header) {
                        $cell->setValue($header['text']);
                        $cell->setFontSize(14);
                        $cell->setFontWeight('bold');
                        $cell->setBorder('medium', 'medium', 'medium', 'medium');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                    });
                }

                $groups = Group::all()->sortByDesc('due_price');

                // Add groups
                for ($i = 0; $i < $groups->count(); $i++) {
                    $row++;
                    $group = $groups->slice($i, 1)->first();

                    for ($j = 0; $j < sizeof($headers) - 1; $j++) {
                        $header = $headers[$j]['prop'];
                        $data = $group->$header;
                        $sheet->cell(chr(ord($col) + $j) . $row, function ($cell) use ($data) {
                            $cell->setValue($data);
                            $cell->setFontSize(12);
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                    }

                    $status = ['text' => '', 'background' => '#FFF', 'foreground' => '#000'];
                    if ($group->due_price > 0) {
                        if ($group->paid == 0) {
                            $status['text'] = 'Not Paid';
                            $status['background'] = '#FFC7CE';
                            $status['foreground'] = '#960000';
                        } else {
                            $status['text'] = 'Partially Paid';
                            $status['background'] = '#FFEB9C';
                            $status['foreground'] = '#9C5700';
                        }
                    } else if ($group->due_price < 0) {
                        $status['text'] = 'Refund';
                        $status['background'] = '#A5A5A5';
                        $status['foreground'] = '#FF0000';
                    } else {
                        $status['text'] = 'Paid';
                        $status['background'] = '#C6EFCE';
                        $status['foreground'] = '#006100';
                    }

                    $sheet->cell(chr(ord($col) + sizeof($headers) - 1) . $row, function ($cell) use ($status) {
                        $cell->setValue($status['text']);
                        $cell->setFontSize(14);
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        $cell->setBackground($status['background']);
                        $cell->setFontColor($status['foreground']);
                    });
                }

                // Set column width
                for ($j = 0; $j < sizeof($headers); $j++) {
                    $sheet->setWidth(chr(ord($col) + $j), 26);
                }
            });
        })->download('xlsx');
    }


}