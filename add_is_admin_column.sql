-- Adicionar coluna is_admin à tabela company_user
ALTER TABLE `company_user` 
ADD COLUMN `is_admin` TINYINT(1) NOT NULL DEFAULT 0 AFTER `role`;
