
-- Cria a tabela de ferramentas.
CREATE TABLE IF NOT EXISTS ferramentas (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Cria a tabela de peças industriais.
CREATE TABLE IF NOT EXISTS pecas_industriais (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    quantidade INTEGER NOT NULL DEFAULT 0 CHECK (quantidade >= 0),
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- Registra as movimentações para fins de auditoria.
CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    peca_id INTEGER NOT NULL REFERENCES pecas_industriais(id),
    quantidade INTEGER NOT NULL CHECK (quantidade > 0),
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('entrada', 'saida')),
    data_movimentacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Insere peças de exemplo somente quando a tabela estiver vazia.
INSERT INTO pecas_industriais (nome, quantidade)
SELECT dados.nome, dados.quantidade
FROM (VALUES
    ('Parafuso industrial', 100),
    ('Porca de aço', 80),
    ('Rolamento', 25),
    ('Correia', 15),
    ('Engrenagem', 10),
    ('Válvula', 20),
    ('Motor elétrico', 5)
) AS dados(nome, quantidade)
WHERE NOT EXISTS (
    SELECT 1 FROM pecas_industriais
);


-- Adiciona a coluna sem alterar os registros existentes.
ALTER TABLE pecas_industriais
ADD COLUMN IF NOT EXISTS ativo BOOLEAN NOT NULL DEFAULT TRUE;
