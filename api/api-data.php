<?php

header('Content-Type: application/json');

// Dados fictícios para simular os cursos
$cursos = [
    'docker' => [
        'nome' => 'Curso de Docker para Iniciantes',
        'descricao' => 'Aprenda a criar, gerenciar e orquestrar contêineres Docker.',
        'duracao' => '20 horas',
        'preco' => 'R$ 299,00'
    ],
    'n8n' => [
        'nome' => 'Automações com n8n',
        'descricao' => 'Crie workflows de automação e conecte centenas de serviços sem código.',
        'duracao' => '15 horas',
        'preco' => 'R$ 249,00'
    ],
    'php' => [
        'nome' => 'Desenvolvimento Web com PHP',
        'descricao' => 'Construa aplicações robustas e seguras usando a linguagem PHP.',
        'duracao' => '30 horas',
        'preco' => 'R$ 399,00'
    ],
];

// Verifica se a API recebeu o parâmetro 'curso'
if (isset($_GET['curso'])) {
    $curso_solicitado = strtolower($_GET['curso']);

    $curso_encontrado = null;
    foreach (array_keys($cursos) as $key) {
        if (stripos($key, $curso_solicitado) !== false) {
            $curso_encontrado = $key;
            break;
        }
    }
    
    if (isset($cursos[$curso_encontrado])) {
        // Retorna as informações do curso específico
        echo json_encode($cursos[$curso_encontrado]);
    } else {
        // Mensagem de erro se o curso não for encontrado
        http_response_code(404);
        echo json_encode(['erro' => 'Curso não encontrado.']);
    }
} else {
    // Retorna a lista de todos os cursos disponíveis
    echo json_encode(['cursos_disponiveis' => array_keys($cursos)]);
}

?>