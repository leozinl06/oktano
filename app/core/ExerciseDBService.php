<?php
class ExerciseDBService {

    public function buscarExercicios($termo) {
        $termo = strtolower(trim($termo));
        
        // Mock: Banco de dados em memória simulando o retorno exato da API
        $mockDatabase = [
            [
                "id" => "mock_001",
                "name" => "supino reto com barra",
                "bodyPart" => "peito",
                "target" => "peitoral",
                "equipment" => "barra",
                "secondaryMuscles" => ["tríceps", "ombros"],
                "instructions" => ["Deite no banco", "Empurre a barra para cima"],
                "difficulty" => "intermediário",
                "category" => "força"
            ],
            [
                "id" => "mock_002",
                "name" => "rosca direta",
                "bodyPart" => "braços",
                "target" => "bíceps",
                "equipment" => "halteres",
                "secondaryMuscles" => ["antebraço"],
                "instructions" => ["Fique em pé", "Flexione os braços"],
                "difficulty" => "iniciante",
                "category" => "força"
            ],
            [
                "id" => "mock_003",
                "name" => "agachamento livre",
                "bodyPart" => "pernas",
                "target" => "quadríceps",
                "equipment" => "barra",
                "secondaryMuscles" => ["glúteos", "panturrilhas"],
                "instructions" => ["Posicione a barra nas costas", "Agache até 90 graus"],
                "difficulty" => "avançado",
                "category" => "força"
            ],
            [
                "id" => "mock_004",
                "name" => "puxada frontal",
                "bodyPart" => "costas",
                "target" => "dorsais",
                "equipment" => "cabo",
                "secondaryMuscles" => ["bíceps", "deltoide posterior"],
                "instructions" => ["Sente na máquina", "Puxe a barra até o peito"],
                "difficulty" => "iniciante",
                "category" => "força"
            ],
            [
                "id" => "mock_005",
                "name" => "leg press 45",
                "bodyPart" => "pernas",
                "target" => "quadríceps",
                "equipment" => "máquina",
                "secondaryMuscles" => ["glúteos"],
                "instructions" => ["Sente no aparelho", "Empurre a plataforma"],
                "difficulty" => "intermediário",
                "category" => "força"
            ],
            [
                "id" => "mock_006",
                "name" => "desenvolvimento com halteres",
                "bodyPart" => "ombros",
                "target" => "deltoides",
                "equipment" => "halteres",
                "secondaryMuscles" => ["tríceps"],
                "instructions" => ["Sente no banco", "Empurre os halteres para cima"],
                "difficulty" => "intermediário",
                "category" => "força"
            ]
        ];

        // Filtra os resultados caso o termo exista no nome, equipamento ou músculo
        $resultados = array_filter($mockDatabase, function($ex) use ($termo) {
            return strpos(strtolower($ex['name']), $termo) !== false || 
                   strpos(strtolower($ex['equipment']), $termo) !== false ||
                   strpos(strtolower($ex['bodyPart']), $termo) !== false;
        });

        // Retorna o array reindexado simulando o JSON da API
        return array_values($resultados);
    }
}