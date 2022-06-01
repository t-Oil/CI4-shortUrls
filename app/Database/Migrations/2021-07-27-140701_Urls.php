<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Urls extends Migration
{
	public function up()
	{
		$fields = [
			'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
			'full_url' => [
				'type' => 'VARCHAR',
				'constraint' => '10000',
				'null' => true
			],
			'qr' => [
				'type' => 'VARCHAR',
				'constraint' => '10000',
				'null' => true
			],
			'count' => [
				'type' => 'INT',
				'constraint' => '11',
				'default' => '0'
			],
			'last_visit_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
		];
		$this->forge->addField('id');
		$this->forge->addField($fields);
		$this->forge->createTable('urls');
	}

	public function down()
	{
		$this->forge->dropTable('urls');
	}
}
