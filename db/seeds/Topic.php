<?php

use Phinx\Seed\AbstractSeed;

class Topic extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
 $csv = <<<EOF
title,tags,status
"What is the first memory you have?","personal",1
"What is your favoritie dish?","personal",1
"What is your favorite color?","personal",1
"Have you lived abroad?","personal",1
EOF;
        $data = array();
        $header = array();
        $arr = explode("\n", $csv);
        $i = -1;
        foreach ($arr as &$line) {
            if (!$line) {
                continue;
            }
            $i++;
            $line = str_getcsv($line);
            if (!$i) {
                $header = $line;
                continue;
            }
            $data[] = array_combine($header, $line);
        }
        $topic = $this->table('topic');
        $topic->insert($data)->save();

    }
}
