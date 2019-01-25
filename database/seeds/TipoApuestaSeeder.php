	<?php

	use Illuminate\Database\Seeder;

	class TipoApuestaSeeder extends Seeder
	{
	    /**
	     * Run the database seeds.
	     *
	     * @return void
	     */
	    public function run()
	    {
	       //1
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (1,1, 1, 'pleno', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (2,1, 2, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (3,1, 3, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (4,1, 4, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (5,1, 5, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (6,1, 6, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (7,1, 7, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (8,1, 8, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (9,1, 9, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (10,1, 10, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (11,1, 11, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (12,1, 12, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (13,1, 13, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (14,1, 14, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (15,1, 15, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (16,1, 16, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (17,1, 17, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (18,1, 18, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (19,1, 19, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (20,1, 20, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (21,1, 21, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (22,1, 22, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (23,1, 23, 'pleno', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (24,1, 24, 'pleno', 1)"));

			// 2
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (25,2, 1, 'Rojo', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (26,2, 2, 'Negro', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (27,2, 3, 'Verde', 1)"));
	    	
	    	// 3 par
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (28,3, 2, '2', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (29,3, 4, '4', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (30,3, 6, '6', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (31,3, 8, '8', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (32,3, 10, '10', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (33,3, 12, '12', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (34,3, 14, '14', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (35,3, 16, '16', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (36,3, 18, '18', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (37,3, 20, '20', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (38,3, 22, '22', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (39,3, 24, '24', 1)"));
	    	//3 impar
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (40,3, 1, 'impar-1', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (41,3, 3, 'impar-3', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (42,3, 5, 'impar-5', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (43,3, 7, 'impar-7', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (44,3, 9, 'impar-9', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (45,3, 11, 'impar-11', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (46,3, 13, 'impar-13', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (47,3, 15, 'impar-15', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (48,3, 17, 'impar-17', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (49,3, 19, 'impar-19', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (50,3, 21, 'impar-21', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (51,3, 23, 'impar-23', 1)"));

	    	//4 1ra media docena
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (52,4, 1, '1era media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (53,4, 1, '1era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (54,4, 1, '1era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (55,4, 1, '1era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (56,4, 1, '1era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (57,4, 1, '1era media', 1)"));

			//4 2da
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (58,4, 2, '2da  media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (59,4, 2, '2da  media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (60,4, 2, '2da  media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (61,4, 2, '2da  media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (62,4, 2, '2da  media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (63,4, 2, '2da  media', 1)"));

			//4 3ra
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (64,4, 3, '3era media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (65,4, 3, '3era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (66,4, 3, '3era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (67,4, 3, '3era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (68,4, 3, '3era media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (69,4, 3, '3era media', 1)"));

			//4 4ta
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (70,4, 4, '4ta media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (71,4, 4, '4ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (72,4, 4, '4ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (73,4, 4, '4ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (74,4, 4, '4ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (75,4, 4, '4ta media', 1)"));


	    //4 5ta
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (76,4, 5, '5ta media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (77,4, 5, '5ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (78,4, 5, '5ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (79,4, 5, '5ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (80,4, 5, '5ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (81,4, 5, '5ta media', 1)"));
		//4 6ta
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (82,4, 6, '6ta media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (83,4, 6, '6ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (84,4, 6, '6ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (85,4, 6, '6ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (86,4, 6, '6ta media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (87,4, 6, '6ta media', 1)"));

			// 7ma
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (88,4, 7, '7ma media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (89,4, 7, '7ma media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (90,4, 7, '7ma media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (91,4, 7, '7ma media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (92,4, 7, '7ma media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (93,4, 7, '7ma media', 1)"));
			//4 8va
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (94,4, 8, '8tava media', 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (95,4, 8, '8tava media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (96,4, 8, '8tava media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (97,4, 8, '8tava media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (98,4, 8, '8tava media', 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (99,4, 8, '8tava media', 1)"));

	    	//5 del 1 al 12
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (100,5, 1, 'del 1 al 12' , 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (101,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (102,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (103,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (104,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (105,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (106,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (107,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (108,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (109,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (110,5, 1, 'del 1 al 12' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (111,5, 1, 'del 1 al 12' , 1)"));

	    	//5 del 13 al 24
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (112,5, 2, 'del 13 al 24' , 1)"));

	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (113,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (114,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (115,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (116,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (117,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (118,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (119,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (120,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (121,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (122,5, 2, 'del 13 al 24' , 1)"));
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (123,5, 2, 'del 13 al 24' , 1)"));

	    	//6 Caja Boveda (0)
	    	DB::select(DB::raw("INSERT INTO tipo_apuesta(idTipoApuesta, idTipoPago ,valorapuesta, nombre,estado)VALUES (124,6, 1.6, 'Caja Bloqueada' , 0)"));
	    }
	}