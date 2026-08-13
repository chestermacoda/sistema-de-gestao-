-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 13-Ago-2026 às 10:39
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fornecimentoagua`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":72,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00001\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(2, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":69,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00002\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(3, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":65,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00003\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(4, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":32,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00004\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(5, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":33,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00005\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(6, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":44,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00006\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(7, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":63,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00007\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(8, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":19,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00008\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(9, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":34,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00009\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(10, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":6,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00010\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(11, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":11,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00011\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(12, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00012\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(13, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":42,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00013\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(14, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":47,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00014\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(15, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":13,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00015\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(16, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":52,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00016\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(17, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":45,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00017\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(18, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":15,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00018\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(19, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":20,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00019\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(20, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":67,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00020\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:10', '2026-07-09 10:04:10'),
(21, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":38,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00021\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:21', '2026-07-09 10:04:21'),
(22, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":58,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00022\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:21', '2026-07-09 10:04:21'),
(23, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":61,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00023\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:21', '2026-07-09 10:04:21'),
(24, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":12,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00024\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:21', '2026-07-09 10:04:21'),
(25, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":41,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00025\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:04:21', '2026-07-09 10:04:21'),
(26, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 1, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":72,\"medidores_id\":92,\"user_id\":6,\"mes_referencia\":\"2026-07-09\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-09 10:04:50', '2026-07-09 10:04:50'),
(27, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 1, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":1,\"consumo_m3\":12,\"valor_consumo\":1800},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-09 10:04:50', '2026-07-09 10:04:50'),
(28, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":79,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00001\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(29, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":40,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00002\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(30, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":70,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00003\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(31, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":25,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00004\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(32, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":5,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00005\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(33, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":62,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00006\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(34, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":74,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00007\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(35, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":64,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00008\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(36, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":22,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00009\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(37, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":9,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00010\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(38, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":53,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00011\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(39, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":35,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00012\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(40, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":38,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00013\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(41, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":58,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00014\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(42, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":61,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00015\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(43, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":12,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00016\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(44, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":41,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00017\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(45, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":37,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00018\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(46, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":72,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00019\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:45', '2026-07-09 10:31:45'),
(47, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":69,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00020\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:45', '2026-07-09 10:31:45'),
(48, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":65,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00021\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:45', '2026-07-09 10:31:45'),
(49, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":32,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00022\",\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-09 10:31:45', '2026-07-09 10:31:45'),
(50, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 1, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":79,\"medidores_id\":4,\"user_id\":6,\"mes_referencia\":\"2026-07-09\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-09 10:32:18', '2026-07-09 10:32:18'),
(51, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 1, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":1,\"consumo_m3\":12,\"valor_consumo\":780},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-09 10:32:18', '2026-07-09 10:32:18'),
(52, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 2, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":72,\"medidores_id\":92,\"user_id\":6,\"mes_referencia\":\"2026-07-11\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"10.000\",\"consumo\":\"10.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-11 14:17:10', '2026-07-11 14:17:10'),
(53, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 19, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":2,\"mes_referencia\":\"2026-07-11\",\"consumo_m3\":10,\"valor_consumo\":1500},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-11 14:17:10', '2026-07-11 14:17:10'),
(54, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1500},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 14:34:09', '2026-07-11 14:34:09'),
(55, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 14:34:09', '2026-07-11 14:34:09'),
(56, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":780},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 14:55:03', '2026-07-11 14:55:03'),
(57, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 14:55:03', '2026-07-11 14:55:03'),
(58, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-11 15:00:10', '2026-07-11 15:00:10'),
(59, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 3, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":40,\"medidores_id\":22,\"user_id\":6,\"mes_referencia\":\"2026-07-11\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-11 15:29:34', '2026-07-11 15:29:34'),
(60, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 2, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":3,\"mes_referencia\":\"2026-07-11\",\"consumo_m3\":12,\"valor_consumo\":1800},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-11 15:29:35', '2026-07-11 15:29:35'),
(61, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1800},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 15:30:34', '2026-07-11 15:30:34'),
(62, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 15:30:34', '2026-07-11 15:30:34'),
(63, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-11 15:32:24', '2026-07-11 15:32:24'),
(64, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 4, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":69,\"medidores_id\":128,\"user_id\":6,\"mes_referencia\":\"2026-07-11\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"9.000\",\"consumo\":\"9.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-11 15:50:05', '2026-07-11 15:50:05'),
(65, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 20, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":4,\"mes_referencia\":\"2026-07-11\",\"consumo_m3\":9,\"valor_consumo\":990},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-11 15:50:05', '2026-07-11 15:50:05'),
(66, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":990},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 15:50:22', '2026-07-11 15:50:22'),
(67, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 16:00:02', '2026-07-11 16:00:02'),
(68, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 5, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":70,\"medidores_id\":133,\"user_id\":6,\"mes_referencia\":\"2026-07-11\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"11.000\",\"consumo\":\"11.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-11 16:00:30', '2026-07-11 16:00:30'),
(69, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 3, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":5,\"mes_referencia\":\"2026-07-11\",\"consumo_m3\":11,\"valor_consumo\":715},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-11 16:00:30', '2026-07-11 16:00:30'),
(70, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":715},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 16:01:06', '2026-07-11 16:01:06'),
(71, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 16:01:06', '2026-07-11 16:01:06'),
(72, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-11 16:26:54', '2026-07-11 16:26:54'),
(73, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 6, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":65,\"medidores_id\":29,\"user_id\":6,\"mes_referencia\":\"2026-07-11\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-11 18:44:10', '2026-07-11 18:44:10'),
(74, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 21, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":6,\"mes_referencia\":\"2026-07-11\",\"consumo_m3\":12,\"valor_consumo\":1320},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-11 18:44:10', '2026-07-11 18:44:10'),
(75, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1320},\"old\":{\"valor_total\":0}}', NULL, '2026-07-11 18:44:30', '2026-07-11 18:44:30'),
(76, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-11 18:44:30', '2026-07-11 18:44:30'),
(77, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 7, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":25,\"medidores_id\":84,\"user_id\":6,\"mes_referencia\":\"2026-07-12\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"10.000\",\"consumo\":\"10.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-12 05:28:52', '2026-07-12 05:28:52'),
(78, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 4, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":7,\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":10,\"valor_consumo\":650},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-12 05:28:52', '2026-07-12 05:28:52'),
(79, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 8, 'App\\Models\\User', 6, '{\"attributes\":{\"cliente_id\":32,\"medidores_id\":18,\"user_id\":6,\"mes_referencia\":\"2026-07-12\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"13.000\",\"consumo\":\"13.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-12 05:29:02', '2026-07-12 05:29:02'),
(80, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 22, 'App\\Models\\User', 6, '{\"attributes\":{\"leitura_id\":8,\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":13,\"valor_consumo\":1430},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-09\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-12 05:29:02', '2026-07-12 05:29:02'),
(81, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":650},\"old\":{\"valor_total\":0}}', NULL, '2026-07-12 05:30:11', '2026-07-12 05:30:11'),
(82, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-12 05:30:11', '2026-07-12 05:30:11'),
(83, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-12 05:49:45', '2026-07-12 05:49:45'),
(84, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1430},\"old\":{\"valor_total\":0}}', NULL, '2026-07-12 05:50:44', '2026-07-12 05:50:44'),
(85, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-12 05:50:44', '2026-07-12 05:50:44'),
(86, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":60,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00023\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(87, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":36,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00024\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(88, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":30,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00025\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(89, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":17,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00026\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(90, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":73,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00027\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(91, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 28, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":14,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00028\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(92, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":59,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00029\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(93, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 30, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":49,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00030\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(94, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 31, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":10,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00031\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(95, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 32, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":54,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00032\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(96, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 33, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":29,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00033\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(97, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 34, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":56,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00034\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(98, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 35, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":48,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00035\",\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(99, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 9, 'App\\Models\\User', 3, '{\"attributes\":{\"cliente_id\":60,\"medidores_id\":62,\"user_id\":3,\"mes_referencia\":\"2026-07-12\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-12 11:14:09', '2026-07-12 11:14:09'),
(100, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 23, 'App\\Models\\User', 3, '{\"attributes\":{\"leitura_id\":9,\"consumo_m3\":12,\"valor_consumo\":1800},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-12 11:14:09', '2026-07-12 11:14:09'),
(101, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1800},\"old\":{\"valor_total\":0}}', NULL, '2026-07-12 11:14:52', '2026-07-12 11:14:52'),
(102, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-12 11:14:52', '2026-07-12 11:14:52'),
(103, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-12 14:40:36', '2026-07-12 14:40:36'),
(104, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 10, 'App\\Models\\User', 3, '{\"attributes\":{\"cliente_id\":36,\"medidores_id\":123,\"user_id\":3,\"mes_referencia\":\"2026-07-12\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-12 15:04:18', '2026-07-12 15:04:18'),
(105, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 24, 'App\\Models\\User', 3, '{\"attributes\":{\"leitura_id\":10,\"consumo_m3\":12,\"valor_consumo\":900},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-12 15:04:18', '2026-07-12 15:04:18'),
(106, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":900},\"old\":{\"valor_total\":0}}', NULL, '2026-07-12 15:04:36', '2026-07-12 15:04:36'),
(107, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-12 15:04:36', '2026-07-12 15:04:36'),
(108, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 11, 'App\\Models\\User', 3, '{\"attributes\":{\"cliente_id\":30,\"medidores_id\":3,\"user_id\":3,\"mes_referencia\":\"2026-07-15\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-15 16:11:14', '2026-07-15 16:11:14'),
(109, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 25, 'App\\Models\\User', 3, '{\"attributes\":{\"leitura_id\":11,\"mes_referencia\":\"2026-07-15\",\"consumo_m3\":12,\"valor_consumo\":1800},\"old\":{\"leitura_id\":null,\"mes_referencia\":\"2026-07-12\",\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-15 16:11:14', '2026-07-15 16:11:14'),
(110, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":1800},\"old\":{\"valor_total\":0}}', NULL, '2026-07-15 16:33:36', '2026-07-15 16:33:36'),
(111, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-15 16:33:36', '2026-07-15 16:33:36'),
(112, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Pago\"},\"old\":{\"status\":\"Parcial\"}}', NULL, '2026-07-15 16:40:47', '2026-07-15 16:40:47'),
(113, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 36, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 14:56:17', '2026-07-16 14:56:17'),
(114, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 37, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 14:56:48', '2026-07-16 14:56:48'),
(115, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 38, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 14:57:31', '2026-07-16 14:57:31'),
(116, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 39, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 14:58:31', '2026-07-16 14:58:31'),
(117, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 40, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:09:40', '2026-07-16 15:09:40'),
(118, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 41, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:11:21', '2026-07-16 15:11:21'),
(119, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 42, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:11:57', '2026-07-16 15:11:57');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(120, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 43, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:13:18', '2026-07-16 15:13:18'),
(121, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 44, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00038\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:13:33', '2026-07-16 15:13:33'),
(122, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 45, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":16,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00039\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:15:19', '2026-07-16 15:15:19'),
(123, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 46, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:24:55', '2026-07-16 15:24:55'),
(124, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 47, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:28:07', '2026-07-16 15:28:07'),
(125, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"medidores_id\":112,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:28:07', '2026-07-16 15:28:07'),
(126, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 48, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:29:45', '2026-07-16 15:29:45'),
(127, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"medidores_id\":112,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:29:45', '2026-07-16 15:29:45'),
(128, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 49, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:30:59', '2026-07-16 15:30:59'),
(129, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"medidores_id\":112,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:30:59', '2026-07-16 15:30:59'),
(130, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 50, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:32:02', '2026-07-16 15:32:02'),
(131, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 51, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:33:44', '2026-07-16 15:33:44'),
(132, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"medidores_id\":112,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:33:44', '2026-07-16 15:33:44'),
(133, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 52, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:34:57', '2026-07-16 15:34:57'),
(134, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":31,\"medidores_id\":112,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:34:57', '2026-07-16 15:34:57'),
(135, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 52, 'App\\Models\\User', 1, '{\"attributes\":{\"leitura_id\":16,\"consumo_m3\":12,\"valor_consumo\":1320},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-16 15:34:57', '2026-07-16 15:34:57'),
(136, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":13,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00036\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:36:14', '2026-07-16 15:36:14'),
(137, 'Leitura', 'Leitura registrada', 'App\\Models\\Leituras', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":13,\"medidores_id\":144,\"user_id\":1,\"mes_referencia\":\"2026-07-16\",\"leitura_anterior\":\"0.000\",\"leitura_atual\":\"12.000\",\"consumo\":\"12.000\",\"status\":\"validada\",\"tem_anomalia\":false,\"tipo_anomalia\":null,\"editada\":false,\"editado_por\":null,\"motivo_edicao\":null,\"observacoes\":null}}', NULL, '2026-07-16 15:36:14', '2026-07-16 15:36:14'),
(138, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"leitura_id\":17,\"consumo_m3\":12,\"valor_consumo\":804},\"old\":{\"leitura_id\":null,\"consumo_m3\":0,\"valor_consumo\":0}}', NULL, '2026-07-16 15:36:14', '2026-07-16 15:36:14'),
(139, 'Fatura', 'Fatura emitida', 'App\\Models\\Faturas', 'created', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"cliente_id\":68,\"leitura_id\":null,\"codigo_fatura\":\"FAT-202607-00037\",\"mes_referencia\":\"2026-07-16\",\"consumo_m3\":0,\"valor_consumo\":0,\"valor_esgoto\":0,\"taxa_disponibilidade\":0,\"multa\":0,\"juros\":0,\"desconto\":0,\"valor_total\":0,\"data_vencimento\":\"2026-07-31T00:00:00.000000Z\",\"status\":\"Pendente\"}}', NULL, '2026-07-16 15:38:11', '2026-07-16 15:38:11'),
(140, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"valor_total\":804},\"old\":{\"valor_total\":0}}', NULL, '2026-07-20 10:31:18', '2026-07-20 10:31:18'),
(141, 'Fatura', 'Fatura alterada', 'App\\Models\\Faturas', 'updated', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"Parcial\"},\"old\":{\"status\":\"Pendente\"}}', NULL, '2026-07-20 10:31:18', '2026-07-20 10:31:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_configuracaos`
--

CREATE TABLE `backup_configuracaos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frequencia` varchar(255) NOT NULL DEFAULT 'semanal',
  `horario` time NOT NULL DEFAULT '02:00:00',
  `retencao_dias` int(11) NOT NULL DEFAULT 30,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `backup_configuracaos`
--

INSERT INTO `backup_configuracaos` (`id`, `frequencia`, `horario`, `retencao_dias`, `status`, `created_at`, `updated_at`) VALUES
(1, 'diario', '02:47:00', 30, 1, '2026-05-11 20:47:13', '2026-05-11 20:48:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `backup_historicos`
--

CREATE TABLE `backup_historicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `tamanho_mb` decimal(10,2) DEFAULT NULL,
  `origem` enum('manual','automatico') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `backup_historicos`
--

INSERT INTO `backup_historicos` (`id`, `arquivo`, `tipo`, `tamanho_mb`, `origem`, `created_at`, `updated_at`) VALUES
(1, 'backup_20260512_094423.sql', 'sql', 0.03, 'automatico', '2026-05-12 07:44:23', '2026-05-12 07:44:23'),
(2, 'backup_20260512_094532.sql', 'sql', 0.03, 'automatico', '2026-05-12 07:45:32', '2026-05-12 07:45:32'),
(3, 'backup_20260512_094817.sql', 'sql', 0.03, 'automatico', '2026-05-12 07:48:18', '2026-05-12 07:48:18'),
(4, 'backup_20260512_180616.sql', 'sql', 0.03, 'automatico', '2026-05-12 16:06:16', '2026-05-12 16:06:16'),
(5, 'backup_20260515_110501.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:05:02', '2026-05-15 09:05:02'),
(6, 'backup_20260515_110601.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:06:01', '2026-05-15 09:06:01'),
(7, 'backup_20260515_110701.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:07:01', '2026-05-15 09:07:01'),
(8, 'backup_20260515_110801.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:08:02', '2026-05-15 09:08:02'),
(9, 'backup_20260515_110901.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:09:02', '2026-05-15 09:09:02'),
(10, 'backup_20260515_111001.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:10:02', '2026-05-15 09:10:02'),
(11, 'backup_20260515_111101.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:11:02', '2026-05-15 09:11:02'),
(12, 'backup_20260515_111201.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:12:02', '2026-05-15 09:12:02'),
(13, 'backup_20260515_111301.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:13:02', '2026-05-15 09:13:02'),
(14, 'backup_20260515_111401.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:14:02', '2026-05-15 09:14:02'),
(15, 'backup_20260515_111501.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:15:02', '2026-05-15 09:15:02'),
(16, 'backup_20260515_111601.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:16:01', '2026-05-15 09:16:01'),
(17, 'backup_20260515_111701.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:17:01', '2026-05-15 09:17:01'),
(18, 'backup_20260515_111801.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:18:01', '2026-05-15 09:18:01'),
(19, 'backup_20260515_111901.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:19:01', '2026-05-15 09:19:01'),
(20, 'backup_20260515_112001.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:20:02', '2026-05-15 09:20:02'),
(21, 'backup_20260515_112101.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:21:02', '2026-05-15 09:21:02'),
(22, 'backup_20260515_112201.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:22:01', '2026-05-15 09:22:01'),
(23, 'backup_20260515_112301.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:23:02', '2026-05-15 09:23:02'),
(24, 'backup_20260515_112401.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:24:02', '2026-05-15 09:24:02'),
(25, 'backup_20260515_112501.sql', 'sql', 0.07, 'automatico', '2026-05-15 09:25:02', '2026-05-15 09:25:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1779472062),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1779472062;', 1779472062),
('laravel-cache-aquanexus@2026|127.0.0.1', 'i:1;', 1779049145),
('laravel-cache-aquanexus@2026|127.0.0.1:timer', 'i:1779049145;', 1779049145),
('laravel-cache-leiturista3@gmail.com|127.0.0.1', 'i:2;', 1783534103),
('laravel-cache-leiturista3@gmail.com|127.0.0.1:timer', 'i:1783534103;', 1783534103),
('laravel-cache-leiurista@gmail.com|127.0.0.1', 'i:2;', 1783534082),
('laravel-cache-leiurista@gmail.com|127.0.0.1:timer', 'i:1783534082;', 1783534082),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:9:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"f\";s:12:\"display_name\";s:1:\"g\";s:6:\"module\";s:1:\"h\";s:11:\"description\";s:1:\"r\";s:5:\"roles\";s:1:\"l\";s:4:\"slug\";s:1:\"m\";s:5:\"color\";}s:11:\"permissions\";a:10:{i:0;a:7:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"clientes.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"Cliente Create\";s:1:\"g\";s:8:\"Clientes\";s:1:\"h\";s:6:\"esf sf\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:7;}}i:1;a:7:{s:1:\"a\";i:12;s:1:\"b\";s:13:\"dashboard.ver\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"Ver Dashboard\";s:1:\"g\";s:9:\"Dashboard\";s:1:\"h\";s:39:\"Permite entrar e ver a pagina dashboad \";s:1:\"r\";a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:7;}}i:2;a:7:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"medidores.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"Criar Medidores\";s:1:\"g\";s:9:\"Medidores\";s:1:\"h\";s:23:\"Permite cria medidores \";s:1:\"r\";a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:7;}}i:3;a:7:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"medidores.editar\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"Editar Medidores\";s:1:\"g\";s:9:\"Medidores\";s:1:\"h\";s:27:\"Permite editar os medidores\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:3;i:2;i:4;i:3;i:7;}}i:4;a:7:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"usuarios.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"Criar Usuarios\";s:1:\"g\";s:8:\"Usuarios\";s:1:\"h\";s:22:\"Permite Criar usuarios\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:5;a:7:{s:1:\"a\";i:17;s:1:\"b\";s:15:\"usuarios.editar\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"Editar Usuarios\";s:1:\"g\";s:8:\"Usuarios\";s:1:\"h\";s:24:\"Permite Editar Usuarios \";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:6;a:7:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"leituras.editar\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"Editar Leituras \";s:1:\"g\";s:8:\"Leituras\";s:1:\"h\";s:32:\"Permite editar Leituras Lancadas\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:7;a:7:{s:1:\"a\";i:19;s:1:\"b\";s:21:\"leituras.gerarfaturas\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:14:\"Gerar Faturas \";s:1:\"g\";s:8:\"Leituras\";s:1:\"h\";s:33:\"Permite gerar fatura das leituras\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:8;a:7:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"leituras.create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"Criar Leitura\";s:1:\"g\";s:8:\"Leituras\";s:1:\"h\";s:38:\"Permite adicionar nova ou cria leitura\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:6;}}i:9;a:7:{s:1:\"a\";i:21;s:1:\"b\";s:17:\"medidores.deletar\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"Deletar Medidores\";s:1:\"g\";s:9:\"Medidores\";s:1:\"h\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:7;}}}s:5:\"roles\";a:5:{i:0;a:6:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"Super Admin\";s:1:\"c\";s:3:\"web\";s:1:\"l\";s:11:\"super-admin\";s:1:\"m\";s:6:\"danger\";s:1:\"h\";s:94:\"Gestão operacional completa. Pode cadastrar e editar clientes, medidores, faturas e leituras.\";}i:1;a:6:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";s:1:\"l\";s:5:\"admin\";s:1:\"m\";s:7:\"primary\";s:1:\"h\";s:92:\"Gestão particial completa. Pode cadastrar e editar clientes, medidores, faturas e leituras.\";}i:2;a:6:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"Financeiro\";s:1:\"c\";s:3:\"web\";s:1:\"l\";s:10:\"financeiro\";s:1:\"m\";s:7:\"warning\";s:1:\"h\";s:87:\"Gestão de clientes. Pode cadastrar e editar clientes, medidores, faturas e pagamentos.\";}i:3;a:6:{s:1:\"a\";i:7;s:1:\"b\";s:17:\"Gerente Medidores\";s:1:\"c\";s:3:\"web\";s:1:\"l\";s:17:\"gerente-medidores\";s:1:\"m\";s:7:\"success\";s:1:\"h\";s:0:\"\";}i:4;a:6:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"Leiturista\";s:1:\"c\";s:3:\"web\";s:1:\"l\";s:10:\"leiturista\";s:1:\"m\";s:6:\"purple\";s:1:\"h\";s:59:\"O presente Role permite o cadastro e a gestao das leituras \";}}}', 1783679291);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_pessoa` enum('fisica','juridica') NOT NULL DEFAULT 'fisica',
  `nome_completo` varchar(255) NOT NULL,
  `bi` varchar(255) NOT NULL,
  `nuit` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `responsavel_legal` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero_casa` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `zona_distribuicao` varchar(255) NOT NULL,
  `ponto_referencia` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `numero_matricula` varchar(255) NOT NULL,
  `categoria_consumo` enum('Residencial','Comercial','Industrial','Público') NOT NULL,
  `tipo_ligacao` enum('Ligação Nova','Transferência','Desmembramento','Regularização') NOT NULL,
  `diametro_ramal` varchar(255) NOT NULL,
  `data_solicitacao` date NOT NULL,
  `data_prevista_ligacao` date DEFAULT NULL,
  `tipo_imovel` varchar(255) NOT NULL,
  `numero_economias` int(11) NOT NULL DEFAULT 1,
  `observacoes` text DEFAULT NULL,
  `status` enum('rascunho','ativo','inativo','suspenso') NOT NULL DEFAULT 'ativo',
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_pessoa`, `nome_completo`, `bi`, `nuit`, `email`, `telefone`, `data_nascimento`, `responsavel_legal`, `cidade`, `endereco`, `numero_casa`, `bairro`, `zona_distribuicao`, `ponto_referencia`, `latitude`, `longitude`, `numero_matricula`, `categoria_consumo`, `tipo_ligacao`, `diametro_ramal`, `data_solicitacao`, `data_prevista_ligacao`, `tipo_imovel`, `numero_economias`, `observacoes`, `status`, `password`, `created_at`, `updated_at`) VALUES
(5, 'fisica', 'Chester Macoda', '1212312123A', '123455', 'chestermacoda@gmail.com', '878107874', '1998-03-02', 'Chester Macoda', 'Maputo', 'Iiberdade Q9', '84', 'liberdade', 'Zona Sul', 'Igreja', NULL, NULL, 'MAT-2026-000001', 'Residencial', 'Ligação Nova', '32mm', '2026-05-13', NULL, 'Casa', 1, '', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-12 21:08:22', '2026-06-15 09:28:29'),
(6, 'fisica', 'Manuel Bata', '987654321B', '765642', 'manuel@gmail.com', '87987654', '1964-05-24', 'Manuel Bata', 'Maputo', 'LIberdade', '84', 'LIberdade', 'Zona Norte', 'Avenida das industrias ', NULL, NULL, 'MAT-2026-000002', 'Residencial', 'Ligação Nova', '32mm', '2026-05-14', NULL, 'Casa', 1, NULL, 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-14 07:14:38', '2026-06-15 09:28:29'),
(7, 'juridica', 'Alexandrine Larkin', 'BI995445019', 'NUIT97180078', 'loma.hintz@example.net', '972.351.5929', '2020-05-20', 'Dortha Welch', 'Evelineland', '360 Alia Village', '744', 'impedit', 'Zona Oeste', 'Eos aliquam et repellat dicta ut.', 21.2913000, 159.9919380, 'MAT-7854439', 'Industrial', 'Ligação Nova', '15mm', '1981-03-24', '1995-12-01', 'Casa', 4, 'Voluptatem sunt totam cupiditate vero.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:49', '2026-06-15 09:28:29'),
(8, 'juridica', 'Wilmer Upton', 'BI837577191', 'NUIT22853149', 'mable63@example.com', '458-396-2976', '1990-07-03', 'Prof. Elsa Boehm III', 'New Newton', '82533 Abigayle Burgs', '870', 'iusto', 'Zona Oeste', 'Quidem consequuntur dolore provident id hic hic minima.', 77.4429590, -107.0631510, 'MAT-8026035', 'Residencial', 'Ligação Nova', '15mm', '1975-01-24', '1972-01-27', 'Casa', 5, 'Animi sed repellendus asperiores et dolores ut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(9, 'juridica', 'Hardy Walsh', 'BI425951623', 'NUIT33402253', 'mueller.keagan@example.org', '385.943.2848', '1976-10-18', 'Ayana Wehner', 'Port Bricebury', '9986 Hermann Curve', '932', 'iusto', 'Zona Sul', 'Tempore nesciunt vel dolorem quae ut cupiditate nihil.', -61.7244880, -60.4050770, 'MAT-6793500', 'Comercial', 'Ligação Nova', '20mm', '1987-06-12', '1987-01-16', 'Casa', 5, 'Non voluptas ut voluptas.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(10, 'fisica', 'Pearl Hauck', 'BI815931715', 'NUIT73699209', 'bernice.haley@example.net', '(520) 729-9825', '2003-05-08', 'Dr. Michael Simonis', 'Emiemouth', '8267 Gutmann Harbors', '280', 'cupiditate', 'Zona Leste', 'Sed sit error dolorem autem assumenda.', 19.8455920, 6.0037580, 'MAT-6810866', 'Residencial', 'Ligação Nova', '20mm', '1998-07-19', '1970-10-23', 'Apartamento', 1, 'Qui itaque qui sint enim nihil ut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(11, 'juridica', 'Mr. Jeremy Marvin Sr.', 'BI589840449', 'NUIT79149821', 'mdonnelly@example.org', '1-484-527-8731', '2022-01-06', 'Walter Terry', 'Kailynton', '211 Reichel Crossroad', '2903', 'debitis', 'Zona Norte', 'Iste sint fuga et.', -2.7151940, -92.4077630, 'MAT-0712136', 'Industrial', 'Ligação Nova', '15mm', '1995-11-27', '2012-06-05', 'Casa', 1, 'Quo totam sunt laudantium culpa tempora dolores.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(12, 'juridica', 'Prof. Cole Deckow', 'BI489838853', 'NUIT08912229', 'cathrine.harber@example.com', '1-509-548-7642', '2011-06-07', 'Ariel Dicki', 'Lake Moshe', '684 Hudson Corner', '568', 'et', 'Zona Sul', 'Aut accusamus omnis amet aut et.', 9.9820550, -169.0372390, 'MAT-5703984', 'Público', 'Ligação Nova', '15mm', '1972-11-29', '2022-10-15', 'Apartamento', 3, 'Error ullam voluptatem nobis qui cupiditate asperiores necessitatibus.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(13, 'juridica', 'Prof. Jason Pfeffer DDS', 'BI275691329', 'NUIT21975403', 'bridie.zemlak@example.com', '920-820-1774', '2011-01-17', 'Mrs. Aditya Tromp', 'Schoenside', '7181 O\'Reilly Lakes Suite 818', '508', 'repellendus', 'Zona Norte', 'Numquam totam tenetur deserunt iste aut accusantium officia.', -57.9447920, 74.2130500, 'MAT-1928694', 'Público', 'Ligação Nova', '20mm', '1971-10-23', '2024-06-22', 'Apartamento', 3, 'Quis in sint doloribus sint.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(14, 'fisica', 'Mr. Terrence Hamill', 'BI136587259', 'NUIT00133371', 'shawn.rowe@example.com', '727.250.2987', '2022-05-23', 'August Corwin', 'Kendallport', '499 White Mews', '67223', 'autem', 'Zona Leste', 'Aliquam neque quia fugiat voluptates.', 59.8452740, -92.6406910, 'MAT-4505615', 'Comercial', 'Ligação Nova', '15mm', '2008-05-28', '2024-05-29', 'Casa', 2, 'Sit omnis tenetur veniam dolorem laudantium porro eos.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(15, 'juridica', 'Ricardo Dickens DVM', 'BI759228617', 'NUIT04261334', 'marlee07@example.com', '(973) 236-2513', '2006-09-12', 'Marion Raynor', 'Corrineland', '578 Franecki Ridges', '584', 'consequuntur', 'Zona Norte', 'Enim cum necessitatibus earum enim.', 8.5050140, 32.1971100, 'MAT-8607137', 'Público', 'Ligação Nova', '20mm', '1978-11-01', '1978-12-25', 'Casa', 2, 'Quia voluptatem iusto qui natus vero recusandae numquam nihil.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(16, 'fisica', 'Ms. Geraldine Bogan', 'BI422228946', 'NUIT88662715', 'ethelyn.mayer@example.com', '1-906-958-9373', '1979-08-23', 'Miss Kianna Connelly', 'North Jarredmouth', '48193 Bergnaum Garden', '6621', 'fuga', 'Zona Norte', 'Omnis laudantium tempora fuga repellat.', -34.6570290, 117.8239140, 'MAT-4394669', 'Público', 'Ligação Nova', '20mm', '1972-06-30', '2012-09-07', 'Apartamento', 5, 'Nihil quo est esse debitis.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(17, 'fisica', 'Katrina Larson', 'BI852758881', 'NUIT40157449', 'cleta99@example.org', '(347) 521-0938', '2009-09-10', 'Green Stroman', 'West Anafort', '87644 Beulah Trail Apt. 210', '5700', 'et', 'Zona Leste', 'Eos qui numquam natus nihil saepe qui.', 65.2758140, -24.9185010, 'MAT-2407407', 'Comercial', 'Ligação Nova', '20mm', '1986-11-01', '2018-04-29', 'Apartamento', 3, 'Dolor ut dolor fuga ut accusamus vel.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(18, 'juridica', 'Korbin Langworth', 'BI924525772', 'NUIT78810733', 'chadd53@example.net', '281-886-1081', '1984-02-09', 'Mr. Kory Larkin', 'Elwintown', '6516 Kaci Forges Suite 229', '53598', 'et', 'Zona Oeste', 'Quidem aspernatur minus quasi illo nemo dolores culpa et.', -27.9900680, -30.5436840, 'MAT-5661005', 'Industrial', 'Ligação Nova', '15mm', '1999-09-10', '2025-01-02', 'Casa', 3, 'Et tenetur reiciendis rerum ea.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(19, 'fisica', 'Letitia Emard', 'BI525617691', 'NUIT21867833', 'glover.ethelyn@example.net', '+1.513.534.2852', '2017-04-20', 'Godfrey Feeney IV', 'Andersonberg', '64135 Maegan Wall', '1708', 'occaecati', 'Zona Norte', 'Dolore tenetur occaecati voluptatem laborum.', -42.7322450, -7.8894810, 'MAT-1396927', 'Industrial', 'Ligação Nova', '15mm', '2015-04-30', '2001-04-25', 'Casa', 1, 'Sint porro fugit quas ipsum qui quos earum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(20, 'juridica', 'Sedrick O\'Reilly', 'BI814951971', 'NUIT74475977', 'okuneva.adolphus@example.net', '480.733.6220', '1990-11-29', 'Jennyfer Mills', 'Port Jarrettport', '8654 Glover Canyon Apt. 909', '2176', 'facere', 'Zona Norte', 'Quo distinctio rem eius minus eligendi laborum debitis.', 27.4679260, 143.5883790, 'MAT-0883491', 'Industrial', 'Ligação Nova', '15mm', '1999-05-29', '1998-10-06', 'Apartamento', 2, 'Numquam autem sapiente quas veritatis at.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(21, 'juridica', 'Evie Cremin', 'BI426126834', 'NUIT55326111', 'maximus.johnson@example.net', '+1-478-949-0885', '1971-08-19', 'Prof. Wilton Monahan DVM', 'Marjorieshire', '5899 Medhurst Lane', '796', 'fugiat', 'Zona Oeste', 'Eum velit qui dicta laudantium.', -29.0637880, 19.9835090, 'MAT-3749768', 'Comercial', 'Ligação Nova', '15mm', '2010-06-15', '2022-09-07', 'Apartamento', 5, 'Veniam est vero nulla et.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(22, 'juridica', 'Eldon Witting', 'BI508374907', 'NUIT25259780', 'stamm.ola@example.net', '1-251-363-1791', '2009-01-12', 'Prof. Damon Maggio', 'South Zoietown', '37446 Dave Wall', '481', 'recusandae', 'Zona Sul', 'Et est repellendus provident doloribus in.', -66.2751380, 72.7646850, 'MAT-2488811', 'Industrial', 'Ligação Nova', '20mm', '1995-02-16', '2014-05-07', 'Casa', 4, 'Eius nam omnis ut quaerat ut at.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(23, 'juridica', 'Mrs. Karen Hyatt', 'BI927282724', 'NUIT96052317', 'tyreek.wehner@example.net', '(657) 782-8746', '1991-09-06', 'Sheila Kemmer', 'Gradyport', '5909 Lynch Knoll Suite 413', '53910', 'quisquam', 'Zona Oeste', 'Eligendi saepe fugiat aut blanditiis voluptatem.', -50.7719500, 175.5002300, 'MAT-7161082', 'Industrial', 'Ligação Nova', '20mm', '1973-01-27', '2025-06-16', 'Casa', 1, 'Quod quisquam iure ipsa dolorem.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(24, 'fisica', 'Lelia Windler', 'BI546273731', 'NUIT07792470', 'gage.leuschke@example.org', '1-469-356-6855', '1980-08-15', 'Eula Bosco', 'South Ledaside', '8605 Maxime Greens', '177', 'ea', 'Zona Oeste', 'Non est quidem vel quasi.', 78.7283490, 172.4056190, 'MAT-6357395', 'Comercial', 'Ligação Nova', '20mm', '2024-10-20', '2015-11-06', 'Casa', 3, 'Nulla sunt eos ipsum velit et quae delectus blanditiis.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(25, 'fisica', 'Brenden Reinger', 'BI151922737', 'NUIT31331747', 'bo.schamberger@example.com', '+1-986-687-7294', '2007-08-13', 'Elvera Abbott', 'New Xzavierhaven', '747 Janiya Lane', '77412', 'quaerat', 'Zona Sul', 'Aut accusamus aut modi.', 18.4194280, 112.3664180, 'MAT-1430938', 'Residencial', 'Ligação Nova', '20mm', '1999-07-18', '2000-02-01', 'Apartamento', 1, 'Quia laborum ab tempore quaerat eligendi perspiciatis.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(26, 'juridica', 'Kelsie Shanahan', 'BI539007165', 'NUIT41176218', 'ijakubowski@example.org', '+19387867481', '2022-05-03', 'Prof. Pablo Connelly II', 'North Stan', '82875 Lavon Inlet', '76504', 'dolore', 'Zona Oeste', 'Vel explicabo qui ex quia a et recusandae.', -11.2445240, 160.3880610, 'MAT-2392907', 'Residencial', 'Ligação Nova', '15mm', '2001-07-29', '2003-02-17', 'Casa', 2, 'Incidunt quas magni eveniet asperiores.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(27, 'fisica', 'Cindy Fisher', 'BI450134089', 'NUIT13340709', 'jovani60@example.net', '908-968-9001', '1991-12-07', 'Eliza Stanton', 'East Torreyfurt', '5334 Hill Bypass', '7585', 'natus', 'Zona Oeste', 'Rerum est aspernatur eaque dolorem libero occaecati dolorem.', -9.2512920, 47.5098430, 'MAT-1966609', 'Residencial', 'Ligação Nova', '20mm', '2009-10-07', '1998-05-08', 'Apartamento', 2, 'Molestias assumenda expedita veniam cupiditate.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(28, 'fisica', 'Lenora Cassin PhD', 'BI662537639', 'NUIT59990024', 'roberts.horace@example.com', '984.539.9246', '1986-09-11', 'Louvenia Tremblay', 'Rocioberg', '3757 Dax Key Apt. 881', '4717', 'earum', 'Zona Oeste', 'Ratione nemo et facilis veritatis repellendus sed illum.', -54.3566380, -73.0206260, 'MAT-9527310', 'Residencial', 'Ligação Nova', '20mm', '2003-06-04', '1991-06-03', 'Apartamento', 2, 'Autem vitae cum excepturi iste temporibus.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(29, 'juridica', 'Prof. Leslie Bogan DVM', 'BI175696330', 'NUIT95886273', 'iwitting@example.com', '+1-469-892-8141', '1999-12-21', 'Mr. Paul Dach', 'Tellyburgh', '801 Hegmann Village', '349', 'iste', 'Zona Leste', 'Qui fugiat quod qui aperiam ut perferendis quae.', -53.9237330, -149.1942650, 'MAT-5122836', 'Público', 'Ligação Nova', '15mm', '1983-04-13', '1997-08-28', 'Apartamento', 3, 'Earum nam dolor rerum vitae illum voluptatibus itaque.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(30, 'juridica', 'Cheyanne Welch V', 'BI041843154', 'NUIT62266055', 'johnson.justyn@example.org', '386.876.4470', '1987-03-17', 'Kavon Botsford', 'South Jarrodton', '7468 Greyson Loaf Suite 211', '59056', 'quod', 'Zona Leste', 'Culpa quis earum ex accusamus in voluptas.', -73.9900180, 166.4758910, 'MAT-6768624', 'Industrial', 'Ligação Nova', '15mm', '1970-11-15', '2008-09-15', 'Casa', 5, 'Velit voluptas ipsa aut quo est et ut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(31, 'fisica', 'Prof. Enos Runolfsdottir', 'BI481481941', 'NUIT44042148', 'abelardo56@example.org', '1-228-663-6993', '1998-06-26', 'Eudora Crona', 'North Cody', '8857 Yost Summit Suite 858', '49521', 'atque', 'Zona Oeste', 'Sunt magni amet exercitationem modi praesentium impedit sapiente.', -15.7863070, -47.3416650, 'MAT-4177614', 'Comercial', 'Ligação Nova', '15mm', '2006-12-19', '1984-07-28', 'Casa', 3, 'Aperiam blanditiis accusantium officia distinctio molestias quis eaque.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(32, 'fisica', 'Hertha Kuvalis', 'BI337266922', 'NUIT81264226', 'maymie51@example.org', '1-628-299-3568', '1971-08-11', 'Miss Freeda Bartell II', 'Kuvalisbury', '6778 O\'Hara Forks', '1537', 'vitae', 'Zona Norte', 'Qui dignissimos voluptas fugiat ut voluptatem voluptatem laboriosam.', -7.3624490, -176.0367740, 'MAT-4725830', 'Comercial', 'Ligação Nova', '15mm', '1983-05-21', '1977-05-02', 'Casa', 5, 'Reiciendis corporis culpa et aut sit.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(33, 'fisica', 'Jalon Hettinger', 'BI481460158', 'NUIT63696994', 'pfeffer.tad@example.com', '+1.202.222.7661', '2009-11-02', 'Dennis Ryan', 'East Lennahaven', '5494 Denesik Road', '696', 'quia', 'Zona Norte', 'Eaque iure rem omnis commodi eligendi ut.', 45.6905030, -168.6125020, 'MAT-8643417', 'Público', 'Ligação Nova', '20mm', '1973-05-11', '2020-08-31', 'Apartamento', 3, 'Aut architecto eius quo quo.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(34, 'juridica', 'Llewellyn Blanda V', 'BI810822509', 'NUIT93838878', 'lysanne39@example.org', '743.592.8236', '1971-02-07', 'Miss Alexanne Balistreri III', 'Raeganberg', '74248 Orrin Common Suite 767', '957', 'eum', 'Zona Norte', 'Voluptatem ut harum accusamus blanditiis quo maxime.', -13.2456110, 29.3957950, 'MAT-6999008', 'Industrial', 'Ligação Nova', '15mm', '2018-03-04', '2011-05-09', 'Casa', 3, 'Et illo qui recusandae ad quidem quibusdam.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(35, 'fisica', 'Katherine Fisher', 'BI943040045', 'NUIT28233999', 'rkuvalis@example.com', '(980) 713-5795', '1994-08-14', 'Camylle Stracke', 'East Mathiaschester', '4580 Zane River Apt. 551', '47451', 'quibusdam', 'Zona Sul', 'Debitis assumenda rerum eum quos unde sed.', -34.5675440, 50.2539120, 'MAT-7230178', 'Industrial', 'Ligação Nova', '15mm', '1982-06-17', '2011-06-24', 'Apartamento', 1, 'Quod aut nesciunt eligendi reprehenderit perferendis voluptas.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(36, 'fisica', 'Braeden Anderson', 'BI699395293', 'NUIT57099566', 'grant.swift@example.org', '269-331-3053', '2009-01-29', 'Ines O\'Reilly', 'East Edwin', '55790 Ullrich Plaza Suite 850', '3490', 'quia', 'Zona Leste', 'Voluptates voluptatem sit et debitis laboriosam voluptatem dolor.', -49.0909380, -17.5361820, 'MAT-4153628', 'Residencial', 'Ligação Nova', '15mm', '1990-11-09', '2006-07-04', 'Apartamento', 2, 'Qui aut suscipit asperiores sed quasi cumque iure.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(37, 'fisica', 'Sanford Reilly', 'BI687133906', 'NUIT67955977', 'casper63@example.org', '(281) 792-1548', '2018-03-01', 'Dr. Hulda Stroman', 'Sawaynshire', '858 Heaven Row Suite 235', '8170', 'odio', 'Zona Sul', 'Vero qui et sint et.', -85.1937170, -104.8407840, 'MAT-4833541', 'Público', 'Ligação Nova', '20mm', '2012-12-11', '2020-11-03', 'Casa', 4, 'Provident officiis repellat quo exercitationem enim et odit aspernatur.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(38, 'juridica', 'Mr. Rusty Heller DVM', 'BI895902013', 'NUIT04104035', 'janie29@example.org', '(972) 762-3855', '2016-02-13', 'Carmella Emmerich', 'Bergemouth', '82289 Rosanna Dam', '4932', 'deleniti', 'Zona Sul', 'Accusantium perspiciatis repellendus facilis omnis.', 21.3453580, -113.3472310, 'MAT-5057660', 'Público', 'Ligação Nova', '15mm', '1984-09-13', '1973-11-11', 'Apartamento', 2, 'Doloremque itaque dignissimos recusandae accusantium in fugit nostrum sit.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(39, 'fisica', 'Carmine Rutherford', 'BI438860811', 'NUIT56528572', 'mazie.farrell@example.com', '(743) 728-3354', '1988-10-12', 'Teresa Wiza', 'North Wymanland', '7480 Leora Stravenue', '9930', 'aliquam', 'Zona Oeste', 'Et dolorem earum ut et.', -71.5178280, -96.7280030, 'MAT-9663585', 'Residencial', 'Ligação Nova', '15mm', '1971-11-27', '2014-06-08', 'Apartamento', 4, 'Fugiat unde numquam eum dolor voluptatum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(40, 'fisica', 'Antonetta Wyman', 'BI164190349', 'NUIT40336002', 'white.adrien@example.org', '+1.458.922.6084', '2010-08-09', 'Gail Stiedemann', 'Lake Chelsea', '66254 Maritza Coves', '82998', 'quam', 'Zona Sul', 'Quis facere debitis laudantium et magnam consequatur voluptatem.', -18.4931480, -140.0807640, 'MAT-3048876', 'Industrial', 'Ligação Nova', '15mm', '1981-04-02', '2016-10-22', 'Casa', 1, 'Dolor assumenda laudantium corporis mollitia.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(41, 'fisica', 'Sandrine Walsh III', 'BI199693591', 'NUIT13410109', 'sid.conn@example.com', '612-950-2467', '2019-10-05', 'Donnie Rempel', 'Port Rahsaan', '27616 Ortiz Radial Suite 496', '1130', 'minima', 'Zona Sul', 'Nobis doloremque enim eaque at earum et est.', 31.0886390, 178.3915070, 'MAT-9954064', 'Público', 'Ligação Nova', '20mm', '1985-10-15', '2005-10-17', 'Casa', 5, 'Dolore eum consequatur eligendi hic.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(42, 'juridica', 'Ms. Matilda Wilkinson', 'BI116005339', 'NUIT85326444', 'oberbrunner.ines@example.net', '(862) 294-9541', '2015-12-17', 'Jaquan Ryan', 'East Justice', '998 Kautzer Forks Suite 396', '58051', 'explicabo', 'Zona Norte', 'Officiis illo quidem asperiores sed ea voluptas aliquam.', -1.9856240, 147.2201520, 'MAT-8036365', 'Comercial', 'Ligação Nova', '15mm', '2008-10-13', '1988-03-02', 'Casa', 2, 'Perspiciatis assumenda eos animi et quia.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(43, 'fisica', 'Willow Farrell', 'BI412184370', 'NUIT34076172', 'abdiel82@example.com', '919.633.0867', '2009-01-19', 'Hildegard Hackett', 'Lake Zackbury', '8455 Frami Expressway Apt. 896', '69673', 'eum', 'Zona Oeste', 'Et quas quidem animi laudantium molestiae.', 68.8930820, 116.9171800, 'MAT-9655872', 'Público', 'Ligação Nova', '15mm', '2026-03-15', '2018-08-19', 'Apartamento', 5, 'Eveniet temporibus blanditiis fugit in et commodi ut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(44, 'fisica', 'Kennith Johnston', 'BI499513792', 'NUIT06456369', 'pebert@example.org', '+1-872-925-6906', '2007-04-20', 'Prof. Collin McClure V', 'South Jordane', '47717 Moen Bridge Apt. 755', '36077', 'qui', 'Zona Norte', 'Tempora et distinctio sit numquam.', 77.0307320, -138.6557000, 'MAT-2308451', 'Comercial', 'Ligação Nova', '15mm', '2006-06-23', '1993-04-17', 'Casa', 3, 'Possimus itaque natus facilis eum tempore quisquam ipsam.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(45, 'juridica', 'Prof. Vallie Kautzer DDS', 'BI112300340', 'NUIT44628199', 'oryan@example.net', '+1 (940) 766-4563', '2004-10-12', 'Madalyn Rempel', 'New Jefferey', '58720 Harvey Throughway', '3429', 'qui', 'Zona Norte', 'Quas minima dolores quisquam sequi iure.', -54.0222520, 38.5719960, 'MAT-1971080', 'Industrial', 'Ligação Nova', '20mm', '2006-01-30', '1984-09-02', 'Casa', 1, 'Ad temporibus iure exercitationem veniam non unde.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(46, 'fisica', 'Hattie Cronin V', 'BI560833744', 'NUIT27932521', 'trace.abbott@example.org', '1-680-922-3555', '1984-08-10', 'Uriel Bayer', 'Ashlyland', '2334 DuBuque Ports', '632', 'deleniti', 'Zona Oeste', 'Fugit aperiam ipsum sapiente.', -34.6097080, -173.8477570, 'MAT-3030022', 'Público', 'Ligação Nova', '15mm', '1992-11-07', '2016-09-30', 'Casa', 1, 'Ab dolor voluptatem nihil.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(47, 'juridica', 'Muriel Ebert III', 'BI002073336', 'NUIT14610419', 'shaina63@example.net', '(615) 354-7414', '2024-03-06', 'Myrl Dickinson', 'Adellchester', '61618 Orville Lock Suite 847', '48033', 'corporis', 'Zona Norte', 'Quisquam velit officia voluptatibus inventore blanditiis.', -57.3921900, -18.4412270, 'MAT-0299691', 'Comercial', 'Ligação Nova', '15mm', '2000-07-30', '2023-12-13', 'Casa', 1, 'Molestias hic nostrum temporibus facilis ipsum totam.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(48, 'fisica', 'Rosalee Grant', 'BI942133944', 'NUIT15963814', 'deven69@example.net', '(276) 494-4224', '1995-01-22', 'Katheryn Russel V', 'Monahanstad', '269 Mueller Lake', '310', 'voluptas', 'Zona Leste', 'Nisi ab eos vero libero aut sed.', 82.4393090, 168.3445810, 'MAT-0617337', 'Industrial', 'Ligação Nova', '20mm', '2006-12-04', '1992-09-02', 'Apartamento', 3, 'Ut harum totam unde et enim sed dolores.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(49, 'juridica', 'Ms. Katlynn Renner', 'BI150011686', 'NUIT53832922', 'mauricio10@example.org', '210-456-0929', '1982-01-29', 'Dr. Toney Ward', 'North Lillianmouth', '76492 Mraz Coves', '47017', 'accusamus', 'Zona Leste', 'Unde consequatur iusto maiores aut deleniti ullam.', 33.7178700, 21.9927570, 'MAT-5787966', 'Industrial', 'Ligação Nova', '15mm', '1978-12-23', '1984-01-12', 'Apartamento', 5, 'Eveniet nisi non asperiores et iusto amet corrupti sint.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(50, 'juridica', 'Mr. Hillard Herman DDS', 'BI844101652', 'NUIT30708207', 'justyn.boyer@example.net', '+1-570-414-5474', '2014-11-23', 'Hilario Prosacco', 'East Casimir', '55525 Nicolas Island', '3710', 'et', 'Zona Oeste', 'Hic dolorum ab deleniti quam quia.', -19.0478870, 160.8713190, 'MAT-1347523', 'Residencial', 'Ligação Nova', '15mm', '2020-09-01', '1995-06-03', 'Casa', 4, 'Autem soluta ut esse qui placeat sapiente.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(51, 'juridica', 'Shanny Fritsch DVM', 'BI561955763', 'NUIT48225723', 'madeline86@example.com', '+1 (743) 934-8813', '1989-09-30', 'Kieran Lehner', 'East Kendrick', '3673 Mueller Roads Suite 619', '919', 'quasi', 'Zona Oeste', 'Unde molestias dolorem dolorum eveniet corrupti et.', 9.8805640, -14.1036240, 'MAT-8868661', 'Industrial', 'Ligação Nova', '15mm', '2019-09-14', '2003-04-04', 'Apartamento', 5, 'Vel soluta rerum numquam minima.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(52, 'fisica', 'Prof. Lloyd Kerluke I', 'BI347362585', 'NUIT09682859', 'nakia.lockman@example.net', '+1-283-212-1681', '2014-02-16', 'Dr. Kaya Treutel', 'Greenfort', '626 Kub Corner Apt. 880', '3140', 'praesentium', 'Zona Norte', 'Minima eum maiores rerum reiciendis qui deserunt totam et.', 34.9383710, -159.9229370, 'MAT-2447374', 'Público', 'Ligação Nova', '15mm', '1976-12-03', '1991-04-27', 'Apartamento', 1, 'Sit eum quasi non aut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(53, 'fisica', 'Jeramy Windler', 'BI116990759', 'NUIT83216228', 'cordelia.schaden@example.net', '1-559-235-7523', '2023-04-25', 'Elva Kohler', 'Douglasburgh', '24010 Yost Crossing Suite 182', '433', 'rerum', 'Zona Sul', 'Aut voluptatem eaque ipsum ea.', 82.1055450, -115.1126150, 'MAT-1558563', 'Público', 'Ligação Nova', '15mm', '2021-06-13', '1979-01-31', 'Casa', 1, 'Eligendi perspiciatis sit laborum culpa dolor.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(54, 'fisica', 'Prof. Erin Lueilwitz II', 'BI554824097', 'NUIT61102355', 'xcollins@example.org', '234.325.9273', '2019-02-07', 'Kayden Homenick', 'West Hermann', '2486 Emile Well Apt. 388', '266', 'esse', 'Zona Leste', 'Laboriosam quia cupiditate nisi dolor.', -69.7871540, -115.6588580, 'MAT-4145214', 'Residencial', 'Ligação Nova', '15mm', '1974-03-05', '1981-02-18', 'Apartamento', 4, 'Voluptatibus tempore qui qui doloremque expedita odio dolorem.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(55, 'juridica', 'Miss Camila Sipes DDS', 'BI370856706', 'NUIT68951971', 'maximillia29@example.org', '314.951.8124', '1988-06-14', 'Brady Rohan', 'East Benton', '571 Wiza Islands Suite 729', '554', 'corrupti', 'Zona Oeste', 'Praesentium natus at consequatur libero voluptate.', -48.6893720, -103.1027610, 'MAT-6338947', 'Industrial', 'Ligação Nova', '15mm', '2003-03-01', '1974-04-21', 'Casa', 5, 'Sunt odio laboriosam et debitis id et laudantium.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(56, 'fisica', 'Queen Schmitt DDS', 'BI428070635', 'NUIT69601962', 'vwiza@example.net', '1-413-540-7644', '2023-10-21', 'Ms. Rahsaan Lakin', 'Kamronfort', '9858 Eda Stream', '32568', 'praesentium', 'Zona Leste', 'Aliquid dolor autem molestias.', 10.3790950, 126.3814150, 'MAT-6189752', 'Público', 'Ligação Nova', '15mm', '1973-11-25', '1985-10-20', 'Casa', 3, 'Quo autem temporibus voluptatem ad.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:25:50', '2026-06-15 09:28:29'),
(57, 'fisica', 'Abraham Durgan', 'BI927428521', 'NUIT56716292', 'ulangosh@example.com', '657-988-0540', '2007-06-06', 'Ms. Gwen Romaguera Sr.', 'South Augustburgh', '710 Chaim Well', '763', 'at', 'Zona Oeste', 'Nemo voluptatem ea vel et cumque doloribus animi.', -27.9850110, -146.8183800, 'MAT-1794549', 'Industrial', 'Ligação Nova', '15mm', '2016-01-13', '1985-06-17', 'Apartamento', 1, 'Voluptatem dicta deleniti at fugiat in consequatur praesentium.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(58, 'fisica', 'Myrtie Kuhlman', 'BI968056235', 'NUIT28565355', 'nolan.wolff@example.net', '+19148186381', '2025-11-19', 'Micah Cummerata', 'Giovannyborough', '96132 Nigel Mountain', '476', 'iure', 'Zona Sul', 'Odio perspiciatis molestiae cum reiciendis.', -36.1037740, -4.2620770, 'MAT-9043455', 'Industrial', 'Ligação Nova', '20mm', '2026-05-01', '1995-05-14', 'Apartamento', 3, 'Illo pariatur et quam eos voluptas nostrum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(59, 'fisica', 'Mrs. Abbey King MD', 'BI693451521', 'NUIT89986577', 'ghickle@example.net', '+19712101099', '2006-02-02', 'Audra Bode', 'Jerrodland', '5255 Barton Point Suite 786', '9644', 'minima', 'Zona Leste', 'Excepturi consequuntur ex molestias blanditiis.', -47.2567210, -51.7581050, 'MAT-4279486', 'Industrial', 'Ligação Nova', '20mm', '1979-09-13', '2019-10-04', 'Apartamento', 1, 'Rerum ea ipsam sunt nihil aliquam temporibus.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(60, 'juridica', 'Alford Keebler', 'BI465091807', 'NUIT47214082', 'qdubuque@example.com', '628-326-1150', '2025-12-23', 'Zander Effertz', 'New Nyahland', '96835 Marques Circle Apt. 926', '956', 'exercitationem', 'Zona Leste', 'Saepe est nisi omnis et.', -20.2794460, 179.4416350, 'MAT-9190767', 'Industrial', 'Ligação Nova', '15mm', '1993-02-27', '2022-12-22', 'Casa', 4, 'Sunt recusandae optio veritatis deleniti sapiente.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(61, 'juridica', 'Nya Davis', 'BI470673494', 'NUIT41553702', 'magdalen18@example.org', '+1-747-406-8171', '1970-08-03', 'Kaci Koelpin Jr.', 'East Vilmaland', '867 Hintz Keys', '67558', 'est', 'Zona Sul', 'Enim repudiandae et unde et ratione quod.', 4.8852540, -66.3908730, 'MAT-4101218', 'Público', 'Ligação Nova', '15mm', '1988-04-03', '2015-06-14', 'Casa', 3, 'Cum labore ea earum alias ut vero magni dolores.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(62, 'fisica', 'Delphia Flatley', 'BI944188350', 'NUIT63256119', 'rene81@example.com', '307-363-8977', '1974-07-23', 'Demarco Roberts', 'Melyssastad', '2774 Heller Junctions', '7517', 'tempore', 'Zona Sul', 'Hic praesentium aut ut velit cum.', 64.6635800, 90.4314100, 'MAT-3735412', 'Público', 'Ligação Nova', '15mm', '1989-03-19', '1983-10-15', 'Casa', 5, 'Id aut molestiae qui hic et fugiat.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(63, 'juridica', 'Laurine Towne', 'BI299009391', 'NUIT64866895', 'jbarrows@example.org', '1-908-224-8417', '2021-12-10', 'Dr. Luther Orn', 'Olinside', '43250 Mozelle Ways Suite 095', '7897', 'illo', 'Zona Norte', 'Reprehenderit quo quo cum esse sequi quas.', 71.7516050, -76.7391060, 'MAT-0958187', 'Comercial', 'Ligação Nova', '15mm', '2005-10-12', '2011-05-25', 'Apartamento', 3, 'At qui fugit illum nobis.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(64, 'juridica', 'Dylan Tillman', 'BI704312612', 'NUIT86751317', 'tre12@example.org', '518.758.6799', '1976-09-12', 'Prof. Wilbert Nader III', 'Katheryntown', '1542 Roxane Crescent', '563', 'aperiam', 'Zona Sul', 'Qui omnis facilis eos ipsam repellendus.', -65.1368440, 30.7035340, 'MAT-7782408', 'Comercial', 'Ligação Nova', '20mm', '1970-07-24', '1993-06-02', 'Casa', 1, 'Magnam sit et sint quasi modi ea.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(65, 'fisica', 'Diana Kub DDS', 'BI900326596', 'NUIT85731572', 'stamm.kaya@example.com', '(551) 206-9615', '2011-04-01', 'Twila Schneider', 'Makaylahaven', '2296 Hodkiewicz Corners Apt. 311', '91808', 'ipsum', 'Zona Norte', 'Magni delectus nisi nihil accusantium facere adipisci assumenda distinctio.', -53.5422050, -129.6511550, 'MAT-1896075', 'Comercial', 'Ligação Nova', '20mm', '2021-04-07', '1984-11-16', 'Casa', 2, 'Accusantium nemo dolores ex dicta est mollitia.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(66, 'juridica', 'Mrs. Leonor Green DDS', 'BI211983732', 'NUIT09505956', 'collier.elliott@example.org', '941.894.0401', '1987-10-18', 'Kale Quitzon Sr.', 'Wisozkmouth', '411 Yasmin Forest', '607', 'unde', 'Zona Oeste', 'Et ad eos quod.', -82.9049480, -175.0489910, 'MAT-7125460', 'Industrial', 'Ligação Nova', '20mm', '2012-04-30', '2021-07-16', 'Apartamento', 2, 'Qui officiis enim aliquam aut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(67, 'juridica', 'Taurean Rohan', 'BI517860882', 'NUIT33238597', 'cristobal23@example.net', '+15079817343', '2024-04-06', 'Prof. Bella Adams', 'South Emma', '7633 Giuseppe Plains', '7798', 'animi', 'Zona Norte', 'Est voluptas reprehenderit sed et cumque inventore voluptatem.', -77.4712680, -98.4942740, 'MAT-8263653', 'Comercial', 'Ligação Nova', '20mm', '2012-12-23', '2018-05-25', 'Casa', 3, 'Ut eum sed sed facilis rerum autem eum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(68, 'juridica', 'Martina Feest DVM', 'BI347547105', 'NUIT12545803', 'awillms@example.net', '+18204462303', '1998-01-12', 'Miss Felipa Bernhard', 'New Diego', '50445 Schinner Knolls', '9795', 'dolorem', 'Zona Oeste', 'Asperiores dolorum voluptatum neque nihil est ipsum est qui.', -16.7053160, -146.0203750, 'MAT-0887867', 'Industrial', 'Ligação Nova', '15mm', '2002-09-06', '1979-03-21', 'Apartamento', 4, 'Consequatur velit illo iusto reprehenderit et.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(69, 'fisica', 'Creola Hansen', 'BI634023006', 'NUIT72499809', 'michaela.rau@example.net', '860-650-0235', '1977-08-10', 'Nia Erdman', 'Cordiamouth', '88195 Hansen Mountains Suite 794', '12925', 'odio', 'Zona Norte', 'Corrupti est corporis dolores saepe et.', 16.7720470, -84.3288780, 'MAT-8731261', 'Comercial', 'Ligação Nova', '15mm', '1992-02-02', '2010-07-09', 'Casa', 1, 'Ut error sunt eveniet veritatis dolorum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(70, 'juridica', 'Berenice Christiansen', 'BI733060574', 'NUIT70356169', 'idooley@example.net', '1-337-591-1416', '1989-10-14', 'Humberto Maggio', 'East Vergie', '2731 Mikayla Spurs Suite 116', '180', 'commodi', 'Zona Sul', 'Animi doloremque aut ratione officiis harum.', -43.9758030, -118.5141430, 'MAT-9579672', 'Residencial', 'Ligação Nova', '20mm', '1996-03-07', '2015-04-10', 'Casa', 3, 'Voluptatibus repellat maiores facilis placeat est.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(71, 'fisica', 'Orland Wolff', 'BI945327981', 'NUIT04470664', 'jennyfer05@example.net', '(214) 335-2303', '1991-02-23', 'Jamir Kunde', 'Gerlachberg', '271 Caleigh Station', '3974', 'aspernatur', 'Zona Oeste', 'Ea voluptas accusantium saepe aliquam quasi et.', -70.7270590, -124.8226100, 'MAT-9695197', 'Público', 'Ligação Nova', '20mm', '2018-03-28', '1982-11-06', 'Apartamento', 1, 'Voluptate voluptatem corporis velit eum non non.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(72, 'fisica', 'Caden Walsh', 'BI480083971', 'NUIT74740698', 'tleuschke@example.net', '970-924-1981', '1990-07-04', 'Ethyl Paucek', 'Rooseveltberg', '2538 Lucio Island', '4920', 'non', 'Zona Norte', 'Qui optio itaque et aut.', 76.5271810, -116.4366460, 'MAT-0154659', 'Industrial', 'Ligação Nova', '20mm', '1977-01-03', '2024-09-27', 'Apartamento', 2, 'Reiciendis nulla non ut corrupti earum praesentium dolorum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(73, 'fisica', 'Mr. Finn Nader', 'BI406323362', 'NUIT37770819', 'vella.parisian@example.org', '828-233-1228', '1975-11-06', 'Bailee Conn', 'Port Richmond', '994 Vincent Mill', '8203', 'ea', 'Zona Leste', 'Adipisci id est porro natus sunt sequi ut.', -55.9369500, 129.9956910, 'MAT-1935436', 'Residencial', 'Ligação Nova', '15mm', '2012-07-02', '1994-07-17', 'Casa', 1, 'Dicta consequatur cupiditate qui eos officiis dolores.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(74, 'juridica', 'Dr. Sister Nikolaus', 'BI179317700', 'NUIT66684914', 'heaney.liza@example.net', '+1-405-737-1269', '2015-09-09', 'Blaise Strosin', 'Jacquelynville', '4814 Columbus Mountain', '2327', 'perferendis', 'Zona Sul', 'Ullam illo quia reprehenderit voluptas earum.', 35.9267030, 3.3924000, 'MAT-9853448', 'Residencial', 'Ligação Nova', '15mm', '2024-09-13', '1992-12-02', 'Casa', 3, 'Tempora ab voluptatibus blanditiis aut.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(75, 'fisica', 'Prof. Jayde Goyette PhD', 'BI681630632', 'NUIT32327422', 'sauer.hayden@example.com', '(920) 896-9755', '2010-08-03', 'Roy Lehner', 'Port Simeonstad', '3431 Idell Ville Suite 351', '6510', 'accusamus', 'Zona Oeste', 'In ratione magni sed est est excepturi rem.', 49.6795830, 91.7213000, 'MAT-6805134', 'Residencial', 'Ligação Nova', '15mm', '2014-09-08', '1992-04-15', 'Apartamento', 1, 'Voluptas praesentium dignissimos nulla ipsum.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(76, 'juridica', 'Dr. Warren Bode', 'BI403420613', 'NUIT67236830', 'doug83@example.org', '(562) 567-1965', '1996-01-10', 'Lorenz DuBuque', 'Juvenalside', '7211 Lubowitz Road', '54429', 'modi', 'Zona Oeste', 'Consequatur et soluta officia vel.', 29.2108720, -71.1819590, 'MAT-0839792', 'Residencial', 'Ligação Nova', '15mm', '1971-04-17', '1972-07-24', 'Casa', 3, 'Eveniet quis dicta quod fugit quo.', 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-05-18 13:26:38', '2026-06-15 09:28:29'),
(79, 'fisica', 'Alan Macoda', '12399123123B', '12232', 'alan@gmail.com', '871231232', '1998-11-25', 'Alan', 'Matola', 'Matola', '84', 'Liberdade', 'Zona Sul', NULL, NULL, NULL, 'MAT-2026-954066', 'Residencial', 'Ligação Nova', '15mm', '2026-06-09', NULL, 'Casa', 1, NULL, 'ativo', '$2y$12$9NYRYqBYCjD.uwPOYltowu19WE2DANBqkwzktiHrIOzlT/xvB.5WG', '2026-06-09 15:50:35', '2026-06-15 09:28:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_medidors`
--

CREATE TABLE `cliente_medidors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `medidor_id` bigint(20) UNSIGNED NOT NULL,
  `leitura_inicial` int(11) NOT NULL DEFAULT 0,
  `data_instalacao` date NOT NULL,
  `local_instalacao` varchar(255) DEFAULT NULL,
  `condicao_hidrometro` varchar(255) DEFAULT NULL,
  `numero_lacre` varchar(255) DEFAULT NULL,
  `vistoria_realizada` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('instalado','Ligação Cortada','manutencao') NOT NULL DEFAULT 'instalado',
  `data_remocao` date DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cliente_medidors`
--

INSERT INTO `cliente_medidors` (`id`, `cliente_id`, `medidor_id`, `leitura_inicial`, `data_instalacao`, `local_instalacao`, `condicao_hidrometro`, `numero_lacre`, `vistoria_realizada`, `status`, `data_remocao`, `observacoes`, `created_at`, `updated_at`) VALUES
(3, 5, 1, 0, '2026-05-13', 'Caixa Subterrânea', 'Novo', NULL, 1, 'instalado', NULL, NULL, '2026-05-12 21:08:22', '2026-05-12 21:08:22'),
(4, 6, 2, 0, '2026-05-14', 'Caixa Subterrânea', 'Novo', NULL, 1, 'instalado', NULL, NULL, '2026-05-14 07:14:38', '2026-05-14 07:14:38'),
(6, 79, 4, 0, '2026-06-09', NULL, 'Novo', NULL, 1, 'instalado', NULL, NULL, '2026-06-09 15:50:35', '2026-06-09 15:50:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `cnpj` varchar(255) NOT NULL,
  `inscricao_estadual` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `endereco_completo` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `companies`
--

INSERT INTO `companies` (`id`, `razao_social`, `nome_fantasia`, `cnpj`, `inscricao_estadual`, `email`, `telefone`, `endereco_completo`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Sistema integrado de gestão e distribuição de fornecimento de água', 'SGF', '12123', '12.345.678/0001-90', 'sondelaaguas@gmail.com', '87123123', 'Matola Av. indústrias', 'logos/rFbGAoGkPU9GKvLlK2N33avTeb03UB5vht8MEblf.png', '2026-05-11 17:12:20', '2026-05-23 16:46:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracao_financeiras`
--

CREATE TABLE `configuracao_financeiras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `multa_atraso` decimal(25,2) NOT NULL DEFAULT 0.00,
  `juros_mes` decimal(25,2) NOT NULL DEFAULT 0.00,
  `dias_tolerancia` int(11) NOT NULL DEFAULT 0,
  `dias_geracao` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `configuracao_financeiras`
--

INSERT INTO `configuracao_financeiras` (`id`, `multa_atraso`, `juros_mes`, `dias_tolerancia`, `dias_geracao`, `created_at`, `updated_at`) VALUES
(1, 50.00, 10.00, 0, 25, '2026-05-11 17:51:39', '2026-07-20 15:39:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes_app`
--

CREATE TABLE `configuracoes_app` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notif_novas_leituras` tinyint(1) NOT NULL DEFAULT 1,
  `notif_anomalias` tinyint(1) NOT NULL DEFAULT 1,
  `notif_sincronizacao` tinyint(1) NOT NULL DEFAULT 0,
  `tema` varchar(255) NOT NULL,
  `modo_offline` tinyint(1) NOT NULL DEFAULT 1,
  `fotos_alta_resolucao` tinyint(1) NOT NULL DEFAULT 0,
  `cache_utilizado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documento_historicos`
--

CREATE TABLE `documento_historicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `fatura_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pagamento_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `arquivo_nome` varchar(255) NOT NULL,
  `arquivo_path` varchar(255) NOT NULL,
  `baixado_em` timestamp NULL DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

CREATE TABLE `faturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `leitura_id` bigint(20) UNSIGNED DEFAULT NULL,
  `codigo_fatura` varchar(255) NOT NULL,
  `mes_referencia` date NOT NULL,
  `periodo_inicio` date NOT NULL,
  `periodo_fim` date NOT NULL,
  `consumo_m3` decimal(10,2) NOT NULL DEFAULT 0.00,
  `valor_consumo` varchar(255) NOT NULL DEFAULT '0.00',
  `valor_esgoto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `taxa_disponibilidade` decimal(10,2) NOT NULL DEFAULT 0.00,
  `multa` decimal(10,2) NOT NULL DEFAULT 0.00,
  `juros` decimal(10,2) NOT NULL DEFAULT 0.00,
  `desconto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `valor_total` decimal(10,2) NOT NULL,
  `valor_pago` int(11) NOT NULL,
  `saldo_atual` decimal(25,2) NOT NULL,
  `negociada` int(11) NOT NULL,
  `parcelas_qtd` int(11) NOT NULL,
  `juros_isento` int(11) NOT NULL,
  `data_emissao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  `status` enum('Pendente','Pago','Parcial','Vencida','Negociada','Cancelada','Estornada') NOT NULL DEFAULT 'Pendente',
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id`, `cliente_id`, `leitura_id`, `codigo_fatura`, `mes_referencia`, `periodo_inicio`, `periodo_fim`, `consumo_m3`, `valor_consumo`, `valor_esgoto`, `taxa_disponibilidade`, `multa`, `juros`, `desconto`, `valor_total`, `valor_pago`, `saldo_atual`, `negociada`, `parcelas_qtd`, `juros_isento`, `data_emissao`, `data_vencimento`, `status`, `observacoes`, `created_at`, `updated_at`) VALUES
(1, 79, 1, 'FAT-202607-00001', '2026-07-09', '2026-07-09', '2026-07-31', 12.00, '780', 0.00, 0.00, 0.00, 0.00, 0.00, 780.00, 780, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:37', '2026-07-11 15:00:10'),
(2, 40, 3, 'FAT-202607-00002', '2026-07-11', '2026-07-09', '2026-07-31', 12.00, '1800', 0.00, 0.00, 0.00, 0.00, 0.00, 1800.00, 9450, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:37', '2026-07-11 15:42:06'),
(3, 70, 5, 'FAT-202607-00003', '2026-07-11', '2026-07-09', '2026-07-31', 11.00, '715', 0.00, 0.00, 0.00, 0.00, 0.00, 715.00, 715, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:37', '2026-07-11 16:26:54'),
(4, 25, 7, 'FAT-202607-00004', '2026-07-12', '2026-07-09', '2026-07-31', 10.00, '650', 0.00, 0.00, 0.00, 0.00, 0.00, 650.00, 650, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:37', '2026-07-12 05:30:11'),
(5, 5, NULL, 'FAT-202607-00005', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(6, 62, NULL, 'FAT-202607-00006', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(7, 74, NULL, 'FAT-202607-00007', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(8, 64, NULL, 'FAT-202607-00008', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(9, 22, NULL, 'FAT-202607-00009', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(10, 9, NULL, 'FAT-202607-00010', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(11, 53, NULL, 'FAT-202607-00011', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(12, 35, NULL, 'FAT-202607-00012', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(13, 38, NULL, 'FAT-202607-00013', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(14, 58, NULL, 'FAT-202607-00014', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(15, 61, NULL, 'FAT-202607-00015', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(16, 12, NULL, 'FAT-202607-00016', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(17, 41, NULL, 'FAT-202607-00017', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(18, 37, NULL, 'FAT-202607-00018', '2026-07-09', '2026-07-09', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pendente', NULL, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(19, 72, 2, 'FAT-202607-00019', '2026-07-11', '2026-07-09', '2026-07-31', 10.00, '1500', 0.00, 0.00, 0.00, 0.00, 0.00, 1500.00, 1500, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:45', '2026-07-11 14:34:09'),
(20, 69, 4, 'FAT-202607-00020', '2026-07-11', '2026-07-09', '2026-07-31', 9.00, '990', 0.00, 0.00, 0.00, 0.00, 0.00, 990.00, 990, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:45', '2026-07-11 16:00:02'),
(21, 65, 6, 'FAT-202607-00021', '2026-07-11', '2026-07-09', '2026-07-31', 12.00, '1320', 0.00, 0.00, 0.00, 0.00, 0.00, 1320.00, 1320, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:45', '2026-07-12 05:49:45'),
(22, 32, 8, 'FAT-202607-00022', '2026-07-12', '2026-07-09', '2026-07-31', 13.00, '1430', 0.00, 0.00, 0.00, 0.00, 0.00, 1430.00, 1430, 0.00, 0, 0, 0, '2026-07-09', '2026-07-31', 'Pago', NULL, '2026-07-09 10:31:45', '2026-07-12 14:40:36'),
(23, 60, 9, 'FAT-202607-00023', '2026-07-12', '2026-07-12', '2026-07-31', 12.00, '1800', 0.00, 0.00, 0.00, 0.00, 0.00, 1800.00, 1800, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pago', NULL, '2026-07-12 11:12:39', '2026-07-12 11:14:52'),
(24, 36, 10, 'FAT-202607-00024', '2026-07-12', '2026-07-12', '2026-07-31', 12.00, '900', 0.00, 0.00, 0.00, 0.00, 0.00, 900.00, 900, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pago', NULL, '2026-07-12 11:12:39', '2026-07-15 16:40:47'),
(25, 30, 11, 'FAT-202607-00025', '2026-07-15', '2026-07-12', '2026-07-31', 12.00, '1800', 0.00, 0.00, 0.00, 0.00, 0.00, 1800.00, 1800, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pago', NULL, '2026-07-12 11:12:39', '2026-07-15 16:33:36'),
(26, 17, NULL, 'FAT-202607-00026', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(27, 73, NULL, 'FAT-202607-00027', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(28, 14, NULL, 'FAT-202607-00028', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(29, 59, NULL, 'FAT-202607-00029', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(30, 49, NULL, 'FAT-202607-00030', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(31, 10, NULL, 'FAT-202607-00031', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(32, 54, NULL, 'FAT-202607-00032', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(33, 29, NULL, 'FAT-202607-00033', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(34, 56, NULL, 'FAT-202607-00034', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(35, 48, NULL, 'FAT-202607-00035', '2026-07-12', '2026-07-12', '2026-07-31', 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 0, 0, 0, '2026-07-12', '2026-07-31', 'Pendente', NULL, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(53, 13, 17, 'FAT-202607-00036', '2026-07-16', '2026-07-16', '2026-07-31', 12.00, '804', 0.00, 0.00, 0.00, 0.00, 0.00, 804.00, 201, 603.00, 0, 0, 0, '2026-07-16', '2026-07-31', 'Parcial', NULL, '2026-07-16 15:36:14', '2026-07-20 10:31:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `leituras`
--

CREATE TABLE `leituras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `medidores_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mes_referencia` date NOT NULL,
  `data_leitura` date NOT NULL,
  `hora_leitura` time NOT NULL,
  `leitura_anterior` decimal(12,2) NOT NULL,
  `leitura_atual` decimal(12,2) NOT NULL,
  `consumo` decimal(12,2) NOT NULL,
  `consumo_medio` decimal(12,2) DEFAULT NULL,
  `status` enum('pendente','validada','anomalia','revisao','faturada','cancelada') NOT NULL DEFAULT 'pendente',
  `tem_anomalia` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_anomalia` varchar(255) DEFAULT NULL,
  `descricao_anomalia` text DEFAULT NULL,
  `acao_corretiva` varchar(255) DEFAULT NULL,
  `editada` tinyint(1) NOT NULL DEFAULT 0,
  `editado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `motivo_edicao` text DEFAULT NULL,
  `editado_em` timestamp NULL DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `confirmada_local` tinyint(1) NOT NULL DEFAULT 1,
  `origem` enum('manual','importacao','mobile','sistema') NOT NULL DEFAULT 'manual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `leituras`
--

INSERT INTO `leituras` (`id`, `cliente_id`, `medidores_id`, `user_id`, `mes_referencia`, `data_leitura`, `hora_leitura`, `leitura_anterior`, `leitura_atual`, `consumo`, `consumo_medio`, `status`, `tem_anomalia`, `tipo_anomalia`, `descricao_anomalia`, `acao_corretiva`, `editada`, `editado_por`, `motivo_edicao`, `editado_em`, `observacoes`, `latitude`, `longitude`, `confirmada_local`, `origem`, `created_at`, `updated_at`) VALUES
(1, 79, 4, 6, '2026-07-09', '2026-07-09', '12:32:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-09 10:32:18', '2026-07-09 10:32:18'),
(2, 72, 92, 6, '2026-07-11', '2026-07-11', '16:17:00', 0.00, 10.00, 10.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-11 14:17:10', '2026-07-11 14:17:10'),
(3, 40, 22, 6, '2026-07-11', '2026-07-11', '17:29:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-11 15:29:34', '2026-07-11 15:29:34'),
(4, 69, 128, 6, '2026-07-11', '2026-07-11', '17:50:00', 0.00, 9.00, 9.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-11 15:50:05', '2026-07-11 15:50:05'),
(5, 70, 133, 6, '2026-07-11', '2026-07-11', '18:00:00', 0.00, 11.00, 11.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-11 16:00:30', '2026-07-11 16:00:30'),
(6, 65, 29, 6, '2026-07-11', '2026-07-11', '20:44:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-11 18:44:10', '2026-07-11 18:44:10'),
(7, 25, 84, 6, '2026-07-12', '2026-07-12', '07:28:00', 0.00, 10.00, 10.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-12 05:28:51', '2026-07-12 05:28:51'),
(8, 32, 18, 6, '2026-07-12', '2026-07-12', '07:29:00', 0.00, 13.00, 13.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-12 05:29:02', '2026-07-12 05:29:02'),
(9, 60, 62, 3, '2026-07-12', '2026-07-12', '13:14:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-12 11:14:09', '2026-07-12 11:14:09'),
(10, 36, 123, 3, '2026-07-12', '2026-07-12', '17:04:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-12 15:04:17', '2026-07-12 15:04:17'),
(11, 30, 3, 3, '2026-07-15', '2026-07-15', '18:11:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'mobile', '2026-07-15 16:11:13', '2026-07-15 16:11:13'),
(17, 13, 144, 1, '2026-07-16', '2026-07-16', '17:36:00', 0.00, 12.00, 12.00, 0.00, 'validada', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'sistema', '2026-07-16 15:36:14', '2026-07-16 15:36:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidores`
--

CREATE TABLE `medidores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `numero_hidrometro` varchar(255) NOT NULL,
  `numero_serie` varchar(255) DEFAULT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `diametro` enum('15mm','20mm','25mm','32mm','40mm','50mm','75mm','100mm') NOT NULL,
  `tipo_hidrometro` varchar(255) NOT NULL,
  `classe_metrologica` enum('Classe A','Classe B','Classe C') DEFAULT NULL,
  `qn` varchar(255) DEFAULT NULL,
  `qmax` varchar(255) DEFAULT NULL,
  `qmin` varchar(255) DEFAULT NULL,
  `ano_fabricacao` year(4) DEFAULT NULL,
  `data_aquisicao` date NOT NULL,
  `fornecedor` varchar(255) DEFAULT NULL,
  `nota_fiscal` varchar(255) DEFAULT NULL,
  `status_inicial` enum('estoque','instalado','Manutencao','Descartado','Cortada') NOT NULL DEFAULT 'estoque',
  `observacoes` text DEFAULT NULL,
  `certificado_calibracao` varchar(255) DEFAULT NULL,
  `laudo_inmetro` varchar(255) DEFAULT NULL,
  `numero_certificado_inmetro` varchar(255) DEFAULT NULL,
  `validade_certificado` date DEFAULT NULL,
  `laboratorio_calibracao` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medidores`
--

INSERT INTO `medidores` (`id`, `cliente_id`, `numero_hidrometro`, `numero_serie`, `marca`, `modelo`, `diametro`, `tipo_hidrometro`, `classe_metrologica`, `qn`, `qmax`, `qmin`, `ano_fabricacao`, `data_aquisicao`, `fornecedor`, `nota_fiscal`, `status_inicial`, `observacoes`, `certificado_calibracao`, `laudo_inmetro`, `numero_certificado_inmetro`, `validade_certificado`, `laboratorio_calibracao`, `quantidade`, `created_at`, `updated_at`) VALUES
(1, 5, 'H-0001-d', '123123A', 'Hydrometer', '', '32mm', 'Eletromagnético', 'Classe C', '1.5', '3.0', '0.03', '2022', '2026-05-10', 'nenhuma', 'NIF', 'instalado', NULL, 'medidores/certificados/pKRhBMUepPIw7h8K91NINesi2DatdQgEM48aHiCr.png', 'medidores/laudos/y3sAS1l8LMv7hjNhjtGaLUIW9Un78DRhTlwZZPBk.pdf', '2123123', '2030-12-31', 'Nnma', 1, '2026-05-12 18:59:57', '2026-05-21 14:04:20'),
(2, 6, 'H-12312', NULL, 'Hersey', NULL, '32mm', 'Smart / Inteligente', 'Classe C', '1.5', '3.0', '0.03', '2026', '2026-05-12', 'Nana', 'NF', 'instalado', NULL, 'medidores/certificados/hTPNFJnBAmQYUgZ6mvN2xeTjmN29rnAbJv8ZH1hH.png', 'medidores/laudos/uyGr9CJxrSShzylUwTkqincyXWkrVldXHFneBu9o.pdf', NULL, '2030-12-31', NULL, 1, '2026-05-12 19:08:33', '2026-05-14 07:14:38'),
(3, 30, 'HM-71384554', 'SR-22691829', 'Elster', 'M-030', '15mm', 'Unijato / Velocidade', 'Classe C', '5.37', '11.11', '0.21', '1970', '2011-09-17', 'Hand and Sons', 'NF-89132507', 'instalado', 'Et ullam vel dolorem et.', '1', '0', 'INM-23875591', '2030-12-31', 'Lemke Ltd', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(4, 79, 'HM-55076910', 'SR-19700215', 'Itron', 'M-587', '20mm', 'Woltman', 'Classe C', '8.15', '11.2', '0.68', '1979', '1988-06-06', 'Weissnat, Yost and Franecki', 'NF-19309048', 'instalado', 'Iusto omnis error ratione quis sapiente.', '1', '1', 'INM-85177766', '2030-12-31', 'Douglas LLC', 1, '2026-05-18 13:07:04', '2026-06-09 18:16:59'),
(5, NULL, 'HM-82153326', 'SR-86197511', 'Arad', 'M-930', '20mm', 'Woltman', 'Classe B', '6.71', '35.88', '0.71', '2012', '2013-06-13', 'Emard, Schmidt and Pacocha', 'NF-12676666', 'estoque', 'Aut qui sunt ipsam atque.', '0', '0', 'INM-87856327', '2030-12-31', 'Fritsch-Hintz', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(6, 38, 'HM-20381764', 'SR-00602719', 'Elster', 'M-047', '25mm', 'Multijato', 'Classe A', '2.7', '48.53', '0.52', '2012', '1986-05-15', 'Lesch, Gerhold and Feeney', 'NF-84964087', 'instalado', 'Ut iste nulla molestiae.', '1', '0', 'INM-39903160', '2030-12-31', 'Koepp, Bayer and McDermott', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(7, 77, 'HM-82713804', 'SR-10818885', 'Elster', 'M-949', '20mm', 'Woltman', 'Classe C', '7.15', '16.44', '0.31', '2001', '1980-06-29', 'Kub-Ritchie', 'NF-66115448', 'estoque', 'Unde explicabo explicabo expedita et.', '1', '0', 'INM-64099736', '2030-12-31', 'Gerhold LLC', 1, '2026-05-18 13:07:04', '2026-06-01 19:02:48'),
(8, NULL, 'HM-79407484', 'SR-97395323', 'Itron', 'M-556', '20mm', 'Multijato', 'Classe B', '5.46', '38.24', '0.64', '2026', '2003-11-01', 'Treutel, Zboncak and Bartoletti', 'NF-08485019', 'estoque', 'Cum et veritatis quas necessitatibus qui porro.', '0', '1', 'INM-06281007', '2030-12-31', 'Rohan-McDermott', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(9, NULL, 'HM-88811457', 'SR-82043543', 'Elster', 'M-854', '25mm', 'Unijato / Velocidade', 'Classe A', '9.87', '40.77', '0.63', '1987', '2022-10-13', 'Terry-Wolf', 'NF-76861834', 'estoque', 'Nam exercitationem autem explicabo deserunt architecto.', '0', '1', 'INM-90527703', '2030-12-31', 'Bosco, Johnston and Grimes', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(10, 47, 'HM-19983944', 'SR-09100069', 'Arad', 'M-950', '15mm', 'Woltman', 'Classe B', '8.78', '18.68', '0.51', '2016', '2001-12-31', 'Barton PLC', 'NF-45248096', 'instalado', 'Consequatur quia non beatae sint fuga maxime.', '0', '1', 'INM-75913052', '2030-12-31', 'Strosin LLC', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:51'),
(11, 59, 'HM-33943774', 'SR-61689281', 'Arad', 'M-925', '20mm', 'Multijato', 'Classe C', '2.78', '27.01', '0.32', '2001', '1975-01-24', 'Funk and Sons', 'NF-19108150', 'instalado', 'Autem iure incidunt soluta fuga quia sit.', '1', '0', 'INM-96172060', '2030-12-31', 'Predovic Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:26:38'),
(12, NULL, 'HM-65833174', 'SR-33198593', 'Elster', 'M-093', '15mm', 'Multijato', 'Classe A', '9.48', '38.77', '0.29', '2007', '2023-08-02', 'King-Morar', 'NF-04095341', 'estoque', 'Est quam tempore sit vitae quod sit doloremque.', '0', '0', 'INM-60688352', '2030-12-31', 'Wisoky Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(13, 18, 'HM-63351638', 'SR-34918167', 'Zenner', 'M-923', '25mm', 'Unijato / Velocidade', 'Classe A', '7.89', '25.78', '0.56', '2020', '1990-11-27', 'Schimmel, Gutmann and Corkery', 'NF-87942130', 'instalado', 'Ullam ducimus delectus corrupti.', '0', '0', 'INM-13228434', '2030-12-31', 'Spinka-Hickle', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(14, NULL, 'HM-56540639', 'SR-68771851', 'Arad', 'M-695', '15mm', 'Woltman', 'Classe C', '3.68', '27.83', '0.77', '2009', '1973-06-22', 'Pacocha and Sons', 'NF-25711723', 'estoque', 'Ipsam incidunt quo ipsum qui molestias incidunt ut.', '1', '0', 'INM-33171384', '2030-12-31', 'Kemmer and Sons', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(15, 11, 'HM-17664356', 'SR-61556962', 'Elster', 'M-353', '15mm', 'Unijato / Velocidade', 'Classe B', '5.49', '42.76', '0.12', '2002', '1980-07-10', 'Runolfsson-Pagac', 'NF-05244965', 'instalado', 'Et eligendi veritatis sed dolor minima.', '0', '1', 'INM-79275007', '2030-12-31', 'Jacobi PLC', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(16, 46, 'HM-54830774', 'SR-29552967', 'Zenner', 'M-799', '25mm', 'Unijato / Velocidade', 'Classe B', '6.77', '27.86', '0.41', '1980', '2001-04-29', 'Flatley-Dietrich', 'NF-42833717', 'instalado', 'Fugiat est modi ut.', '1', '0', 'INM-14960918', '2030-12-31', 'Hill Inc', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:51'),
(17, 66, 'HM-26167314', 'SR-63696687', 'Zenner', 'M-598', '20mm', 'Multijato', 'Classe C', '6.49', '23.92', '0.49', '2021', '2003-05-07', 'Daugherty, Ledner and Goldner', 'NF-42140836', 'instalado', 'Mollitia eaque voluptatem minima et.', '0', '1', 'INM-59116151', '2030-12-31', 'Lueilwitz-Hagenes', 1, '2026-05-18 13:07:04', '2026-05-18 13:26:38'),
(18, 32, 'HM-67028619', 'SR-73811391', 'Arad', 'M-197', '15mm', 'Woltman', 'Classe C', '1.78', '29.03', '0.45', '2013', '1988-01-25', 'Schoen-Gottlieb', 'NF-35286619', 'instalado', 'Enim assumenda quod et dolor eveniet perspiciatis corporis et.', '0', '1', 'INM-89982707', '2030-12-31', 'Cassin-Feest', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(19, NULL, 'HM-21852295', 'SR-32221612', 'Zenner', 'M-796', '25mm', 'Multijato', 'Classe A', '2.27', '18.53', '0.43', '1996', '1994-09-02', 'Wilderman-Larkin', 'NF-75627474', 'estoque', 'Doloremque quos nemo velit similique.', '1', '1', 'INM-90634871', '2030-12-31', 'Cormier-McClure', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(20, NULL, 'HM-86832340', 'SR-36383447', 'Arad', 'M-904', '20mm', 'Woltman', 'Classe B', '1.53', '43.1', '0.5', '1997', '1999-11-04', 'Feeney-Kiehn', 'NF-49987556', 'estoque', 'Pariatur eos reprehenderit et assumenda consequatur incidunt.', '1', '0', 'INM-90383481', '2030-12-31', 'Balistreri-Hane', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(21, NULL, 'HM-96869960', 'SR-96440533', 'Arad', 'M-098', '15mm', 'Unijato / Velocidade', 'Classe A', '3.82', '26.41', '0.5', '1978', '2013-01-08', 'Kovacek Ltd', 'NF-12024535', 'estoque', 'Nostrum ducimus illum et soluta libero vitae.', '0', '0', 'INM-30247400', '2030-12-31', 'Hermiston-Carroll', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(22, 40, 'HM-04009787', 'SR-71265948', 'Zenner', 'M-740', '25mm', 'Woltman', 'Classe A', '7.06', '17.55', '0.81', '1981', '2001-05-31', 'Watsica-Sawayn', 'NF-69046250', 'instalado', 'Officia cumque et eveniet eveniet dolor in vitae.', '1', '1', 'INM-90125961', '2030-12-31', 'Howell, Brakus and Muller', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(23, NULL, 'HM-64609294', 'SR-88164873', 'Itron', 'M-773', '15mm', 'Woltman', 'Classe C', '2.97', '14.44', '0.56', '2013', '1992-06-29', 'Schimmel-Kessler', 'NF-27370187', 'estoque', 'Fugit nobis fugit earum dolorem maxime.', '1', '1', 'INM-50368287', '2030-12-31', 'Abernathy, Trantow and Marquardt', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(24, NULL, 'HM-68962820', 'SR-07220951', 'Zenner', 'M-429', '15mm', 'Unijato / Velocidade', 'Classe A', '3.5', '17.07', '0.73', '1994', '1995-12-29', 'Waters LLC', 'NF-10570339', 'estoque', 'Eos aut repellendus quis officiis itaque quis aliquid.', '0', '0', 'INM-40766848', '2030-12-31', 'Sauer Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(25, NULL, 'HM-59559853', 'SR-00140019', 'Arad', 'M-828', '25mm', 'Multijato', 'Classe C', '6.59', '14.6', '0.36', '2012', '1998-02-20', 'Bahringer LLC', 'NF-28791149', 'estoque', 'Quos fugiat magnam et quia consequatur rerum.', '1', '0', 'INM-37907178', '2030-12-31', 'Stanton-Mertz', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(26, NULL, 'HM-29390740', 'SR-97195265', 'Elster', 'M-031', '20mm', 'Unijato / Velocidade', 'Classe C', '1.21', '49.36', '0.29', '2025', '1988-01-11', 'Block, Crist and Pollich', 'NF-32578767', 'estoque', 'Ipsam autem vitae blanditiis sed tenetur.', '1', '1', 'INM-59258881', '2030-12-31', 'Jast-Kassulke', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(27, NULL, 'HM-51759407', 'SR-36807444', 'Itron', 'M-541', '20mm', 'Multijato', 'Classe B', '2.57', '43.53', '0.88', '2003', '2025-11-13', 'Grimes, Ferry and Batz', 'NF-00476058', 'estoque', 'Et blanditiis molestiae sit.', '1', '1', 'INM-70506231', '2030-12-31', 'Moore Inc', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(28, NULL, 'HM-96325556', 'SR-11906786', 'Arad', 'M-153', '25mm', 'Woltman', 'Classe C', '7.1', '28.95', '0.78', '1975', '2000-12-22', 'Spencer-Heller', 'NF-56446391', 'estoque', 'Non possimus amet et.', '1', '0', 'INM-71695931', '2030-12-31', 'Collins, Reinger and Lehner', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(29, 65, 'HM-90903789', 'SR-91732863', 'Zenner', 'M-612', '25mm', 'Woltman', 'Classe B', '1.59', '28.05', '0.93', '2004', '1970-01-16', 'Schmeler-Kunde', 'NF-36926761', 'instalado', 'Animi temporibus corporis veniam voluptatem vitae ab quis pariatur.', '0', '1', 'INM-45601624', '2030-12-31', 'Okuneva-McKenzie', 1, '2026-05-18 13:07:04', '2026-05-18 13:26:38'),
(30, NULL, 'HM-00523058', 'SR-37646308', 'Itron', 'M-264', '20mm', 'Multijato', 'Classe B', '5.23', '34.51', '0.13', '2012', '1977-11-12', 'Morar-Cremin', 'NF-02353248', 'estoque', 'Voluptas quasi id aut.', '1', '0', 'INM-09270154', '2030-12-31', 'Barrows LLC', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(31, NULL, 'HM-69536752', 'SR-23273505', 'Elster', 'M-738', '25mm', 'Unijato / Velocidade', 'Classe A', '7.92', '15.74', '0.66', '1997', '2015-04-25', 'Abshire, Anderson and Metz', 'NF-82516711', 'estoque', 'Voluptas possimus qui vel temporibus molestias.', '0', '1', 'INM-81576288', '2030-12-31', 'Harris-Schulist', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(32, 9, 'HM-16728209', 'SR-60400133', 'Zenner', 'M-540', '25mm', 'Multijato', 'Classe C', '6.85', '20.15', '0.5', '2011', '2010-05-09', 'Dicki, Botsford and Hudson', 'NF-05982296', 'instalado', 'Et omnis enim sint officiis suscipit.', '0', '0', 'INM-45161871', '2030-12-31', 'Schaefer-Kunde', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(33, NULL, 'HM-33421756', 'SR-43161659', 'Itron', 'M-106', '15mm', 'Multijato', 'Classe A', '4.69', '47.17', '0.3', '1995', '2014-09-06', 'Bode, Koss and Kiehn', 'NF-42530765', 'estoque', 'Velit recusandae et dolorem et at labore nesciunt.', '1', '1', 'INM-46587219', '2030-12-31', 'Becker Inc', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(34, NULL, 'HM-88609749', 'SR-85151203', 'Elster', 'M-413', '25mm', 'Unijato / Velocidade', 'Classe A', '8.17', '36.25', '0.95', '2012', '2024-08-20', 'Stokes Ltd', 'NF-50598633', 'estoque', 'Dolorem accusantium animi voluptatem excepturi quasi libero aspernatur.', '1', '1', 'INM-70699907', '2030-12-31', 'Armstrong Ltd', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(35, NULL, 'HM-59837190', 'SR-45278815', 'Arad', 'M-239', '25mm', 'Unijato / Velocidade', 'Classe C', '3.25', '40.84', '0.11', '1985', '1987-08-14', 'Schoen, Heidenreich and Turcotte', 'NF-79434727', 'estoque', 'Quis omnis id ea ad.', '1', '1', 'INM-75096731', '2030-12-31', 'Gerlach Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(36, NULL, 'HM-63938802', 'SR-27038828', 'Itron', 'M-193', '20mm', 'Multijato', 'Classe B', '9.54', '45.3', '0.26', '1989', '2025-06-10', 'Zieme PLC', 'NF-54052810', 'estoque', 'Unde ipsam voluptate accusamus.', '0', '1', 'INM-84637507', '2030-12-31', 'Russel Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(37, NULL, 'HM-25142071', 'SR-49254510', 'Arad', 'M-004', '20mm', 'Woltman', 'Classe C', '1.17', '12.73', '0.25', '2017', '1984-07-02', 'Reilly-Cummings', 'NF-76657022', 'estoque', 'Rerum vero totam ea ratione.', '1', '0', 'INM-73081484', '2030-12-31', 'Parker PLC', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(38, 34, 'HM-42079076', 'SR-78394486', 'Elster', 'M-467', '20mm', 'Multijato', 'Classe B', '4.55', '24.46', '0.91', '1976', '2000-01-15', 'Marks Inc', 'NF-40823882', 'instalado', 'Dolore eius ullam numquam aut omnis ab illum.', '1', '1', 'INM-97426588', '2030-12-31', 'Cruickshank, Wyman and Ziemann', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(39, NULL, 'HM-89232402', 'SR-51184398', 'Itron', 'M-838', '25mm', 'Woltman', 'Classe C', '9.36', '37.97', '0.96', '2023', '2004-06-10', 'Heathcote-Green', 'NF-89360314', 'estoque', 'Debitis non velit voluptas distinctio est et id dolore.', '0', '0', 'INM-59844468', '2030-12-31', 'Daniel, Ondricka and Kshlerin', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(40, 17, 'HM-07631424', 'SR-73844173', 'Elster', 'M-229', '25mm', 'Woltman', 'Classe C', '8.6', '44.31', '0.46', '1977', '2014-01-06', 'Deckow-Kutch', 'NF-06654189', 'instalado', 'Ullam non non voluptatem temporibus non tempore odit.', '0', '1', 'INM-58527963', '2030-12-31', 'Konopelski PLC', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(41, 27, 'HM-37971165', 'SR-00764031', 'Arad', 'M-745', '25mm', 'Unijato / Velocidade', 'Classe B', '4.54', '21.65', '0.11', '2021', '1971-09-07', 'Gerhold-Bailey', 'NF-77764984', 'instalado', 'Autem et officia dolorem illum quasi voluptates.', '1', '1', 'INM-73770377', '2030-12-31', 'Jast Ltd', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(42, NULL, 'HM-48554813', 'SR-03756268', 'Arad', 'M-298', '20mm', 'Woltman', 'Classe B', '7.6', '43.22', '0.51', '2022', '2007-11-27', 'Wiegand-Stoltenberg', 'NF-95141858', 'estoque', 'Eaque ut ut dicta omnis ut.', '0', '0', 'INM-67989223', '2030-12-31', 'Ruecker, Heller and Pouros', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(43, NULL, 'HM-07169140', 'SR-70934424', 'Arad', 'M-480', '20mm', 'Woltman', 'Classe B', '6.93', '44.1', '0.99', '2012', '2024-01-10', 'Crist, Macejkovic and Zemlak', 'NF-55683188', 'estoque', 'Nostrum dolorem dolorem error excepturi omnis repellat eaque placeat.', '1', '0', 'INM-53485656', '2030-12-31', 'Predovic, Jones and Gaylord', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(44, NULL, 'HM-36956107', 'SR-96035782', 'Itron', 'M-332', '20mm', 'Woltman', 'Classe A', '9.05', '27.65', '0.38', '2007', '2009-10-02', 'Rolfson-Labadie', 'NF-86129498', 'estoque', 'Quasi laboriosam nobis rerum itaque consequuntur dolor corporis.', '1', '1', 'INM-05584104', '2030-12-31', 'Kirlin-Bosco', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(45, 48, 'HM-53999363', 'SR-96149201', 'Zenner', 'M-047', '15mm', 'Multijato', 'Classe B', '1.26', '34.25', '0.79', '1994', '1991-03-28', 'Cremin, Carter and Wolff', 'NF-35743822', 'instalado', 'Molestiae ut libero non officia est facere.', '0', '0', 'INM-19825829', '2030-12-31', 'Beer, Bechtelar and Welch', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:51'),
(46, NULL, 'HM-14798178', 'SR-93328995', 'Itron', 'M-772', '20mm', 'Multijato', 'Classe C', '3.41', '27.55', '0.41', '2008', '2005-10-19', 'Orn LLC', 'NF-88476769', 'estoque', 'Et voluptatibus distinctio nulla quia autem quia.', '1', '0', 'INM-94522244', '2030-12-31', 'Zboncak, Dare and Schoen', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(47, 61, 'HM-29038524', 'SR-05556651', 'Arad', 'M-159', '15mm', 'Woltman', 'Classe A', '2.43', '11.8', '0.74', '2019', '1989-03-03', 'Keebler, Schimmel and Price', 'NF-35409447', 'instalado', 'Rerum voluptatem fuga omnis tenetur.', '0', '0', 'INM-93315282', '2030-12-31', 'Mohr Group', 1, '2026-05-18 13:07:04', '2026-05-18 13:26:38'),
(48, NULL, 'HM-60963823', 'SR-28626276', 'Arad', 'M-504', '25mm', 'Unijato / Velocidade', 'Classe A', '3.85', '12.81', '0.99', '1983', '1991-11-17', 'Stokes Inc', 'NF-48642907', 'estoque', 'Dolorem veniam consequatur hic natus.', '0', '1', 'INM-03289485', '2030-12-31', 'McLaughlin-Grady', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(49, NULL, 'HM-12873434', 'SR-57545065', 'Arad', 'M-904', '25mm', 'Unijato / Velocidade', 'Classe B', '4.84', '24.56', '0.7', '1980', '2015-07-21', 'Hodkiewicz-Nitzsche', 'NF-47942566', 'estoque', 'Quo nulla recusandae eum enim non.', '1', '1', 'INM-40419122', '2030-12-31', 'Schaefer-Strosin', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(50, NULL, 'HM-46814135', 'SR-33241383', 'Zenner', 'M-438', '20mm', 'Unijato / Velocidade', 'Classe B', '5.23', '17.93', '0.57', '1984', '2018-03-15', 'Hammes-Will', 'NF-49503326', 'estoque', 'Excepturi aperiam dicta et repellat totam qui dolor.', '1', '1', 'INM-80297689', '2030-12-31', 'Rutherford, O\'Keefe and Schaefer', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(51, NULL, 'HM-24568529', 'SR-62099491', 'Elster', 'M-858', '20mm', 'Unijato / Velocidade', 'Classe B', '8.07', '10.85', '0.62', '2015', '1992-03-30', 'Blanda-Johns', 'NF-85696317', 'estoque', 'Eligendi aut officiis rerum itaque non cupiditate.', '1', '0', 'INM-07674015', '2030-12-31', 'Wintheiser, Torphy and Boyer', 1, '2026-05-18 13:07:04', '2026-05-18 13:07:04'),
(52, 35, 'HM-84456190', 'SR-30248409', 'Arad', 'M-801', '15mm', 'Multijato', 'Classe B', '2.64', '24.42', '0.33', '2000', '1971-01-21', 'Jenkins-Shields', 'NF-27667394', 'instalado', 'Voluptatem ut velit eaque illum dolor nostrum.', '1', '0', 'INM-65762745', '2030-12-31', 'VonRueden-Huels', 1, '2026-05-18 13:07:04', '2026-05-18 13:25:50'),
(53, NULL, 'HM-08372278', 'SR-24035747', 'Arad', 'M-971', '15mm', 'Woltman', 'Classe C', '2.31', '41.99', '0.52', '1988', '2011-08-24', 'Jones-Kuhic', 'NF-38075106', 'estoque', 'Sed quisquam est dicta doloremque.', '1', '0', 'INM-56322592', '2030-12-31', 'Rohan, Skiles and Greenholt', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(54, NULL, 'HM-69403954', 'SR-55253263', 'Zenner', 'M-398', '15mm', 'Unijato / Velocidade', 'Classe C', '2.11', '33.09', '0.15', '2017', '2013-03-25', 'Kulas-Kuhn', 'NF-26256565', 'estoque', 'Et vero nobis dolorem vero voluptates ipsum ut.', '0', '0', 'INM-69530894', '2030-12-31', 'Leuschke, Larson and Bashirian', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(55, NULL, 'HM-38303718', 'SR-09608707', 'Arad', 'M-321', '25mm', 'Unijato / Velocidade', 'Classe B', '3.94', '39.32', '0.55', '1978', '1986-07-29', 'Rowe, Nitzsche and Walker', 'NF-37511492', 'estoque', 'Voluptas deleniti eius aspernatur sit nesciunt modi adipisci.', '0', '1', 'INM-14776025', '2030-12-31', 'Erdman-Zemlak', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(56, 37, 'HM-30093826', 'SR-79121464', 'Arad', 'M-673', '20mm', 'Unijato / Velocidade', 'Classe A', '4.77', '32.99', '0.6', '2005', '1975-03-24', 'Hills, Turner and Bechtelar', 'NF-08379899', 'instalado', 'Et autem omnis officiis.', '1', '0', 'INM-00762586', '2030-12-31', 'Swaniawski PLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(57, NULL, 'HM-49831102', 'SR-69887669', 'Itron', 'M-872', '15mm', 'Multijato', 'Classe B', '8.54', '42.21', '0.91', '1972', '1970-12-04', 'Hickle PLC', 'NF-78184839', 'estoque', 'Et eligendi cum natus expedita nobis voluptatum.', '1', '0', 'INM-92684844', '2030-12-31', 'Upton, Schroeder and Kutch', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(58, 74, 'HM-77718471', 'SR-10785084', 'Elster', 'M-072', '25mm', 'Unijato / Velocidade', 'Classe B', '2.7', '15.04', '0.46', '2017', '1973-04-19', 'Koch-Daugherty', 'NF-92570664', 'instalado', 'Quaerat eos omnis ut sunt voluptatem.', '0', '0', 'INM-13928263', '2030-12-31', 'Schaefer-Bechtelar', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(59, NULL, 'HM-05843105', 'SR-32287773', 'Zenner', 'M-732', '20mm', 'Multijato', 'Classe B', '8.24', '31.1', '0.58', '2006', '1991-03-15', 'Corkery Group', 'NF-59381886', 'estoque', 'Qui quia non voluptatibus minima ea.', '0', '0', 'INM-03954783', '2030-12-31', 'Konopelski Ltd', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(60, NULL, 'HM-00909735', 'SR-96851929', 'Zenner', 'M-969', '25mm', 'Woltman', 'Classe A', '2.7', '44.57', '0.88', '1999', '2015-01-21', 'Christiansen and Sons', 'NF-90394560', 'estoque', 'Omnis aut qui magni mollitia.', '1', '0', 'INM-69958956', '2030-12-31', 'Stoltenberg-Olson', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(61, NULL, 'HM-62778309', 'SR-26761267', 'Arad', 'M-898', '25mm', 'Woltman', 'Classe A', '1.11', '41.86', '0.7', '1979', '2010-06-13', 'Stroman Group', 'NF-51564042', 'estoque', 'Sit voluptatum quas aut laudantium omnis nostrum expedita.', '1', '1', 'INM-54031474', '2030-12-31', 'Hegmann, Hoeger and Reichert', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(62, 60, 'HM-53796324', 'SR-77178323', 'Elster', 'M-140', '20mm', 'Woltman', 'Classe A', '8.97', '20.1', '0.14', '1987', '2024-04-05', 'Luettgen LLC', 'NF-59036688', 'instalado', 'Dolor nam rerum minima harum et minima.', '1', '1', 'INM-65250311', '2030-12-31', 'Bartell, Roob and Halvorson', 1, '2026-05-18 13:07:36', '2026-05-21 13:46:53'),
(63, NULL, 'HM-62095410', 'SR-73166286', 'Zenner', 'M-620', '25mm', 'Woltman', 'Classe B', '2.68', '21.94', '0.13', '2004', '2024-01-07', 'Keebler Group', 'NF-89263406', 'estoque', 'Dolore fuga temporibus iste numquam maiores.', '0', '1', 'INM-72309448', '2030-12-31', 'Friesen, Connelly and Rath', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(64, 49, 'HM-22578672', 'SR-67293626', 'Arad', 'M-338', '25mm', 'Multijato', 'Classe A', '9.83', '28.76', '0.61', '2014', '2000-03-29', 'Greenholt Ltd', 'NF-01860146', 'instalado', 'Consequatur est culpa blanditiis in temporibus.', '1', '1', 'INM-99008978', '2030-12-31', 'Walsh-Heathcote', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(65, NULL, 'HM-27406284', 'SR-20707521', 'Arad', 'M-785', '25mm', 'Multijato', 'Classe C', '6.08', '24.68', '0.28', '2016', '2001-08-09', 'Rosenbaum-Lubowitz', 'NF-39242779', 'estoque', 'Voluptatem et et ullam iusto dolores velit eum repellat.', '0', '0', 'INM-36124842', '2030-12-31', 'Bosco-Dickens', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(66, NULL, 'HM-17948192', 'SR-06474356', 'Arad', 'M-514', '25mm', 'Woltman', 'Classe B', '2.69', '21.32', '0.96', '2004', '1991-01-07', 'Friesen-Flatley', 'NF-63142806', 'estoque', 'Ut at libero quas autem laudantium.', '1', '1', 'INM-69226309', '2030-12-31', 'Thiel, Stiedemann and Farrell', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(67, NULL, 'HM-23882150', 'SR-77806119', 'Arad', 'M-353', '20mm', 'Woltman', 'Classe C', '9.06', '40.58', '0.7', '1988', '2007-03-31', 'Dooley, Abshire and Kunze', 'NF-63723733', 'estoque', 'Atque quisquam possimus eligendi vel.', '1', '0', 'INM-52836219', '2030-12-31', 'Bruen, Lemke and Prosacco', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(68, NULL, 'HM-59407269', 'SR-29817147', 'Arad', 'M-939', '25mm', 'Woltman', 'Classe A', '2.18', '40.16', '0.13', '2001', '1987-09-20', 'Sipes LLC', 'NF-48016419', 'estoque', 'Quam voluptatem necessitatibus quaerat.', '1', '1', 'INM-78658044', '2030-12-31', 'Bayer and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(69, NULL, 'HM-82085801', 'SR-39035143', 'Arad', 'M-906', '15mm', 'Woltman', 'Classe C', '4.34', '32.7', '0.92', '1990', '1984-08-18', 'Nikolaus and Sons', 'NF-92851670', 'estoque', 'Sed minus in at exercitationem ipsum labore.', '1', '0', 'INM-02798363', '2030-12-31', 'Feest-Schimmel', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(70, 64, 'HM-08587140', 'SR-14825550', 'Itron', 'M-541', '25mm', 'Woltman', 'Classe C', '3.8', '22.32', '0.86', '1983', '1987-08-15', 'Hegmann Group', 'NF-10176389', 'instalado', 'Cupiditate odit eos est esse atque corrupti provident.', '0', '1', 'INM-26993582', '2030-12-31', 'Vandervort Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(71, 67, 'HM-42972160', 'SR-72844600', 'Arad', 'M-583', '25mm', 'Woltman', 'Classe C', '3.9', '40.18', '0.27', '1986', '1994-10-28', 'West, Reilly and Hodkiewicz', 'NF-77507466', 'instalado', 'Minima cum ut sunt voluptatibus fuga facere.', '1', '0', 'INM-97639407', '2030-12-31', 'Auer, Friesen and Hettinger', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(72, 16, 'HM-48994595', 'SR-25197531', 'Arad', 'M-469', '15mm', 'Multijato', 'Classe A', '2.17', '19.37', '0.26', '1996', '1981-12-07', 'Klein, Gorczany and Gleichner', 'NF-55550784', 'instalado', 'Excepturi qui incidunt sit esse aspernatur quo ut et.', '0', '1', 'INM-86278572', '2030-12-31', 'O\'Hara-Farrell', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(73, NULL, 'HM-56278839', 'SR-06514828', 'Elster', 'M-599', '25mm', 'Unijato / Velocidade', 'Classe A', '4.39', '42.83', '0.8', '2010', '1990-06-25', 'Ward-Heidenreich', 'NF-95166590', 'estoque', 'In voluptatibus nisi numquam.', '1', '1', 'INM-31392364', '2030-12-31', 'Flatley-Bailey', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(74, NULL, 'HM-43631394', 'SR-51645524', 'Arad', 'M-498', '20mm', 'Multijato', 'Classe C', '3.14', '17.79', '0.11', '1979', '2006-10-27', 'Hand Group', 'NF-85043105', 'estoque', 'Iste iusto vel quidem quo necessitatibus similique.', '1', '1', 'INM-79754861', '2030-12-31', 'Bailey Group', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(75, NULL, 'HM-35980236', 'SR-11688910', 'Itron', 'M-804', '15mm', 'Multijato', 'Classe C', '9.11', '46.14', '0.96', '2024', '2001-04-14', 'Heaney PLC', 'NF-69043069', 'estoque', 'Dignissimos et asperiores veritatis aut minima.', '1', '0', 'INM-48391399', '2030-12-31', 'Gaylord, Mayer and Wuckert', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(76, 15, 'HM-77386072', 'SR-84813148', 'Arad', 'M-347', '25mm', 'Woltman', 'Classe A', '1.36', '32.16', '0.98', '2022', '1970-02-05', 'Ryan Inc', 'NF-18588280', 'instalado', 'Totam a nesciunt rem.', '1', '0', 'INM-40369223', '2030-12-31', 'Murazik and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(77, 63, 'HM-51348549', 'SR-29278481', 'Itron', 'M-688', '15mm', 'Multijato', 'Classe C', '5.85', '24.15', '0.13', '2007', '2016-07-23', 'Kshlerin Ltd', 'NF-91700021', 'instalado', 'Sit et impedit nisi cumque rerum non modi laborum.', '1', '0', 'INM-72280638', '2030-12-31', 'Spencer-Runolfsdottir', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(78, 41, 'HM-08411520', 'SR-71924843', 'Arad', 'M-272', '20mm', 'Woltman', 'Classe B', '6.02', '48.37', '0.17', '1977', '1980-08-29', 'Wintheiser, Langosh and Murazik', 'NF-19676918', 'instalado', 'Blanditiis ut deserunt architecto autem expedita adipisci iure.', '0', '1', 'INM-94289682', '2030-12-31', 'Auer, Lueilwitz and Frami', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(79, 44, 'HM-32079730', 'SR-88658824', 'Elster', 'M-066', '25mm', 'Multijato', 'Classe C', '8.99', '41.58', '0.52', '1981', '1982-07-23', 'Pfannerstill Ltd', 'NF-37107910', 'instalado', 'Nemo adipisci placeat est quasi.', '1', '0', 'INM-14363674', '2030-12-31', 'Torphy, Ankunding and Heaney', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(80, 22, 'HM-67160171', 'SR-03867574', 'Itron', 'M-341', '20mm', 'Multijato', 'Classe A', '1.11', '21.41', '0.27', '2010', '2010-05-29', 'Denesik, Welch and Cassin', 'NF-03833581', 'instalado', 'Accusamus rerum molestiae qui molestias aliquam facilis id.', '1', '1', 'INM-70560369', '2030-12-31', 'Cruickshank-McLaughlin', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(81, NULL, 'HM-22486139', 'SR-88188285', 'Arad', 'M-369', '20mm', 'Woltman', 'Classe A', '8.21', '49.45', '0.14', '2013', '2018-12-15', 'Satterfield LLC', 'NF-04834167', 'estoque', 'Voluptate et nihil architecto nihil molestiae deleniti.', '1', '1', 'INM-55964387', '2030-12-31', 'Kilback PLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(82, NULL, 'HM-56823327', 'SR-29056806', 'Itron', 'M-506', '20mm', 'Unijato / Velocidade', 'Classe C', '5.54', '47.29', '0.82', '2012', '2006-03-19', 'West-Greenholt', 'NF-38076796', 'estoque', 'Commodi laboriosam non consectetur voluptas vel.', '1', '0', 'INM-39704737', '2030-12-31', 'Schuster, Emard and Dicki', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(83, NULL, 'HM-48927931', 'SR-34684305', 'Arad', 'M-766', '25mm', 'Multijato', 'Classe C', '6.2', '46.13', '0.18', '2010', '2016-02-01', 'Heller-Lehner', 'NF-21680046', 'estoque', 'Fugit veritatis culpa praesentium occaecati aut illum tempora voluptatem.', '0', '1', 'INM-50896256', '2030-12-31', 'Denesik-Lindgren', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(84, 25, 'HM-65104844', 'SR-78665784', 'Elster', 'M-381', '20mm', 'Unijato / Velocidade', 'Classe B', '2.95', '29.69', '0.35', '2015', '1983-03-07', 'Morissette LLC', 'NF-54508403', 'instalado', 'Minus doloremque vero in quaerat tempora dignissimos molestiae.', '1', '0', 'INM-23127519', '2030-12-31', 'Trantow-Gerhold', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(85, NULL, 'HM-32856804', 'SR-85263682', 'Elster', 'M-924', '25mm', 'Unijato / Velocidade', 'Classe C', '4.42', '34.26', '0.86', '2015', '1991-09-27', 'Hermiston Ltd', 'NF-80948947', 'estoque', 'Exercitationem culpa necessitatibus iste eveniet omnis ea facilis.', '0', '1', 'INM-32851624', '2030-12-31', 'Collins-Kovacek', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(86, 56, 'HM-08364813', 'SR-19288593', 'Arad', 'M-044', '20mm', 'Unijato / Velocidade', 'Classe C', '6.1', '28.96', '0.94', '1995', '2005-05-24', 'Muller, Oberbrunner and Senger', 'NF-50077308', 'instalado', 'Quidem possimus facilis incidunt est.', '0', '1', 'INM-70405606', '2030-12-31', 'Price and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(87, NULL, 'HM-98993384', 'SR-07048888', 'Itron', 'M-692', '25mm', 'Unijato / Velocidade', 'Classe C', '4.79', '29', '0.41', '2012', '2000-01-13', 'Swift and Sons', 'NF-97590384', 'estoque', 'Et atque accusamus pariatur fuga et.', '0', '0', 'INM-09067060', '2030-12-31', 'Grady, Mueller and Pollich', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(88, 51, 'HM-55536569', 'SR-50801437', 'Itron', 'M-936', '25mm', 'Unijato / Velocidade', 'Classe B', '8.72', '14.91', '0.56', '1971', '2019-03-10', 'Kozey, Veum and Rice', 'NF-02126330', 'instalado', 'Occaecati fugit expedita quia sint temporibus.', '0', '1', 'INM-22976009', '2030-12-31', 'Price and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(89, NULL, 'HM-31362636', 'SR-11362927', 'Elster', 'M-487', '20mm', 'Woltman', 'Classe C', '9.36', '28.83', '0.39', '1972', '2026-03-11', 'Prohaska-Kunze', 'NF-77956442', 'estoque', 'Culpa autem ut reprehenderit qui doloribus non.', '1', '0', 'INM-30083938', '2030-12-31', 'Senger-Haley', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(90, 42, 'HM-21012038', 'SR-56712570', 'Itron', 'M-658', '25mm', 'Multijato', 'Classe A', '3.82', '22.39', '0.95', '1987', '2020-04-21', 'Schuster and Sons', 'NF-26584647', 'instalado', 'Dolorem ipsam earum vel molestiae et fuga maiores.', '1', '0', 'INM-22053065', '2030-12-31', 'Bauch, Collins and Mayer', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(91, 24, 'HM-31553358', 'SR-61720065', 'Itron', 'M-515', '20mm', 'Unijato / Velocidade', 'Classe A', '7.09', '26.97', '0.85', '1983', '2010-03-08', 'Wintheiser-Hilpert', 'NF-12933841', 'instalado', 'Aliquid laboriosam laborum voluptatem reprehenderit debitis.', '1', '1', 'INM-34396742', '2030-12-31', 'Schaefer-Prosacco', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(92, 72, 'HM-69120334', 'SR-24409763', 'Zenner', 'M-543', '15mm', 'Unijato / Velocidade', 'Classe C', '2.04', '28.86', '0.98', '2016', '2004-11-03', 'Blanda and Sons', 'NF-83090037', 'instalado', 'Cupiditate omnis sequi et illum et aut eum.', '0', '1', 'INM-28337356', '2030-12-31', 'D\'Amore PLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(93, NULL, 'HM-60571987', 'SR-56794700', 'Itron', 'M-600', '15mm', 'Woltman', 'Classe B', '4.63', '14.51', '0.54', '2005', '2024-11-27', 'Bartell, Bailey and Emard', 'NF-87244625', 'estoque', 'Iste odio est mollitia ut vel accusamus.', '1', '0', 'INM-92632512', '2030-12-31', 'Buckridge-Schulist', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(94, NULL, 'HM-97964879', 'SR-82410688', 'Itron', 'M-273', '20mm', 'Unijato / Velocidade', 'Classe B', '8.9', '19', '0.54', '1972', '2006-04-19', 'Beahan and Sons', 'NF-98035017', 'estoque', 'Est odit tempora modi ut harum sint corporis.', '0', '1', 'INM-12781354', '2030-12-31', 'Raynor, Russel and Bode', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(95, 50, 'HM-17522443', 'SR-46523054', 'Zenner', 'M-281', '15mm', 'Woltman', 'Classe A', '4.83', '47.25', '0.77', '2023', '2021-09-15', 'Jacobs-Durgan', 'NF-57148764', 'instalado', 'Enim hic dolores ad non eos dignissimos.', '1', '1', 'INM-32819883', '2030-12-31', 'Rodriguez Ltd', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(96, 55, 'HM-06769128', 'SR-83210696', 'Arad', 'M-711', '25mm', 'Woltman', 'Classe B', '9.98', '44.6', '0.13', '2025', '1981-11-14', 'Morissette, Reynolds and Weimann', 'NF-91604068', 'instalado', 'In error corporis molestias et aperiam et non.', '0', '0', 'INM-41612523', '2030-12-31', 'Ondricka, Halvorson and Kerluke', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(97, NULL, 'HM-30061848', 'SR-15091700', 'Zenner', 'M-013', '25mm', 'Unijato / Velocidade', 'Classe B', '3.55', '15.52', '0.78', '2010', '1993-09-11', 'Koepp, Buckridge and Skiles', 'NF-87653955', 'estoque', 'Omnis modi eligendi tempora vero nemo aspernatur.', '0', '0', 'INM-64122399', '2030-12-31', 'Hettinger Group', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(98, 23, 'HM-44719906', 'SR-44006844', 'Elster', 'M-813', '20mm', 'Woltman', 'Classe A', '1.66', '31.36', '0.53', '2009', '1981-09-18', 'Hills and Sons', 'NF-81840921', 'instalado', 'Maxime amet commodi sed molestiae quia iusto rerum.', '0', '1', 'INM-93270747', '2030-12-31', 'Tromp, Abbott and Heller', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(99, NULL, 'HM-56077430', 'SR-04799816', 'Itron', 'M-370', '25mm', 'Unijato / Velocidade', 'Classe A', '9.51', '18.35', '0.37', '1993', '1983-07-27', 'Lang, Koelpin and Kiehn', 'NF-95882873', 'estoque', 'Maiores commodi veritatis et labore aut a cum.', '1', '1', 'INM-56373436', '2030-12-31', 'Moore, Brown and Gleichner', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(100, 68, 'HM-67014880', 'SR-96356291', 'Itron', 'M-926', '20mm', 'Unijato / Velocidade', 'Classe C', '3.66', '47.73', '0.34', '1991', '2014-07-19', 'O\'Kon-Cummings', 'NF-79737268', 'instalado', 'Atque autem iure est neque.', '1', '0', 'INM-01697068', '2030-12-31', 'Turcotte Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(101, 19, 'HM-89814552', 'SR-38631649', 'Elster', 'M-256', '20mm', 'Woltman', 'Classe B', '1.11', '42.97', '0.81', '1998', '1981-08-06', 'Wintheiser, Kemmer and Williamson', 'NF-42815343', 'instalado', 'Velit ullam sapiente consectetur omnis cupiditate praesentium.', '0', '1', 'INM-89183002', '2030-12-31', 'Powlowski-Gerlach', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(102, NULL, 'HM-72345567', 'SR-05370093', 'Zenner', 'M-906', '25mm', 'Woltman', 'Classe B', '6.92', '34.48', '0.75', '2024', '1990-09-19', 'Waelchi, Ward and Gaylord', 'NF-10762089', 'estoque', 'Ut iure explicabo aut perferendis repudiandae.', '0', '1', 'INM-27654742', '2030-12-31', 'Conn Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(103, NULL, 'HM-06713871', 'SR-19812935', 'Itron', 'M-797', '20mm', 'Multijato', 'Classe C', '2.68', '25.29', '0.86', '1975', '1970-05-22', 'Zieme Group', 'NF-38480667', 'estoque', 'Sunt voluptatem praesentium et minus omnis.', '0', '0', 'INM-13145213', '2030-12-31', 'Sipes, Pouros and Goldner', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(104, 52, 'HM-22214439', 'SR-36318100', 'Zenner', 'M-304', '20mm', 'Unijato / Velocidade', 'Classe B', '7.83', '25.57', '0.14', '1991', '1976-02-15', 'Oberbrunner-Walker', 'NF-42226982', 'instalado', 'Sequi est sint quas nisi quo.', '1', '1', 'INM-97161441', '2030-12-31', 'Lowe-Weber', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(105, 21, 'HM-64417969', 'SR-35571643', 'Itron', 'M-335', '25mm', 'Unijato / Velocidade', 'Classe B', '2.34', '26.32', '0.83', '1977', '1995-05-03', 'Braun-Halvorson', 'NF-84018835', 'instalado', 'Sequi sed aliquam minus et voluptates rem.', '1', '1', 'INM-11783653', '2030-12-31', 'Johns LLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(106, 26, 'HM-14186938', 'SR-11622665', 'Zenner', 'M-643', '20mm', 'Unijato / Velocidade', 'Classe B', '1.89', '17.45', '0.88', '1998', '1976-11-29', 'Jacobi-Kautzer', 'NF-86164100', 'instalado', 'Maiores voluptas esse eius itaque qui ullam.', '1', '0', 'INM-01344191', '2030-12-31', 'Ebert, Stoltenberg and Corkery', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(107, NULL, 'HM-11715501', 'SR-41802146', 'Elster', 'M-363', '25mm', 'Multijato', 'Classe A', '9.19', '16.53', '0.73', '1975', '1997-04-06', 'O\'Conner, Kautzer and Cronin', 'NF-99198364', 'estoque', 'Facere amet et autem.', '0', '0', 'INM-67581075', '2030-12-31', 'Orn and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(108, 58, 'HM-68211881', 'SR-61202213', 'Arad', 'M-072', '20mm', 'Multijato', 'Classe C', '1.38', '35.71', '0.62', '1992', '1998-06-28', 'Dickinson Group', 'NF-16213913', 'instalado', 'Nihil eum doloremque quas quia.', '0', '1', 'INM-64761488', '2030-12-31', 'Gutmann and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(109, 7, 'HM-16842932', 'SR-36077164', 'Zenner', 'M-182', '20mm', 'Woltman', 'Classe C', '3.77', '21.97', '0.37', '1997', '2012-11-28', 'Frami, Beatty and Blanda', 'NF-97872636', 'instalado', 'Nihil quo distinctio enim blanditiis aut maxime quaerat.', '0', '1', 'INM-80146544', '2030-12-31', 'Swaniawski Ltd', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(110, NULL, 'HM-30339951', 'SR-32407370', 'Zenner', 'M-012', '15mm', 'Multijato', 'Classe C', '9.35', '26.86', '0.36', '2014', '1982-07-18', 'Yundt, Maggio and Jast', 'NF-30390596', 'estoque', 'Omnis pariatur et quidem ducimus vero eos et.', '0', '1', 'INM-25303909', '2030-12-31', 'Fay-Mann', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(111, 28, 'HM-32433992', 'SR-46892930', 'Zenner', 'M-317', '20mm', 'Unijato / Velocidade', 'Classe A', '6.94', '26.08', '0.63', '1982', '1990-12-17', 'Grady Inc', 'NF-86511255', 'instalado', 'Est est et ut alias qui perspiciatis.', '1', '0', 'INM-44122270', '2030-12-31', 'Hilpert Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(112, 31, 'HM-11109665', 'SR-93527142', 'Arad', 'M-723', '25mm', 'Unijato / Velocidade', 'Classe C', '1.71', '11.78', '0.98', '2026', '1987-05-17', 'Daniel-Christiansen', 'NF-47337954', 'instalado', 'Nobis est voluptate nihil incidunt quas aut ut.', '1', '0', 'INM-61880518', '2030-12-31', 'Wiegand, Graham and Stehr', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(113, NULL, 'HM-35105433', 'SR-15761798', 'Arad', 'M-574', '15mm', 'Woltman', 'Classe A', '1.95', '42.83', '0.93', '2002', '2014-05-12', 'Schmeler-Hoppe', 'NF-92457592', 'estoque', 'Blanditiis id odio id magni ut voluptas.', '0', '0', 'INM-40902331', '2030-12-31', 'Raynor LLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(114, 45, 'HM-37434730', 'SR-76591901', 'Arad', 'M-769', '15mm', 'Woltman', 'Classe B', '5.18', '38.32', '0.78', '2010', '2022-08-02', 'Bogan-Klein', 'NF-14441812', 'instalado', 'Labore repellendus at labore molestiae velit.', '1', '0', 'INM-75272233', '2030-12-31', 'Klein, Altenwerth and Monahan', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(115, NULL, 'HM-08309954', 'SR-59100370', 'Elster', 'M-282', '25mm', 'Multijato', 'Classe A', '1.32', '30.48', '0.21', '2024', '1973-10-15', 'Mayer-Friesen', 'NF-12503832', 'estoque', 'Sequi et et sit voluptates et dolores non et.', '1', '0', 'INM-12649548', '2030-12-31', 'Jerde, Lubowitz and Gusikowski', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(116, 76, 'HM-00161147', 'SR-30761199', 'Zenner', 'M-225', '25mm', 'Woltman', 'Classe B', '4.28', '14.8', '0.28', '1995', '2020-05-29', 'Weissnat Inc', 'NF-22744401', 'instalado', 'Reprehenderit eum ut id saepe illo et voluptatum.', '0', '1', 'INM-12441384', '2030-12-31', 'Pfeffer-Boyer', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(117, 53, 'HM-93601805', 'SR-24218034', 'Zenner', 'M-052', '25mm', 'Woltman', 'Classe B', '8.9', '20.46', '0.28', '2011', '1982-12-13', 'Schinner, Harris and Rau', 'NF-91861518', 'instalado', 'Itaque exercitationem fugiat assumenda qui eius doloremque.', '1', '1', 'INM-90554118', '2030-12-31', 'Blanda-Langworth', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(118, 39, 'HM-52935826', 'SR-95172975', 'Itron', 'M-274', '25mm', 'Woltman', 'Classe C', '1.82', '41.77', '0.37', '1970', '2003-01-08', 'Funk, Hand and Koss', 'NF-34980296', 'instalado', 'Libero ut quod quia eos occaecati.', '1', '1', 'INM-79071822', '2030-12-31', 'Turcotte-Waters', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(119, 14, 'HM-25975320', 'SR-77513658', 'Zenner', 'M-200', '15mm', 'Unijato / Velocidade', 'Classe A', '6.28', '16.21', '0.94', '1979', '1987-03-06', 'Hoeger, Mosciski and Macejkovic', 'NF-53898751', 'instalado', 'Rerum repellendus necessitatibus soluta sapiente vel qui sed.', '1', '1', 'INM-13042317', '2030-12-31', 'Hintz-Rippin', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(120, 20, 'HM-04740860', 'SR-70546756', 'Arad', 'M-247', '25mm', 'Unijato / Velocidade', 'Classe B', '9.36', '10.76', '0.48', '1995', '1983-03-02', 'Crist LLC', 'NF-26261189', 'instalado', 'Enim vitae et neque ratione qui.', '1', '1', 'INM-53674770', '2030-12-31', 'Kassulke, Dibbert and Barton', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(121, NULL, 'HM-17234987', 'SR-63386547', 'Arad', 'M-625', '20mm', 'Woltman', 'Classe C', '9.86', '38.24', '0.76', '2015', '1998-01-28', 'O\'Kon-Frami', 'NF-53844758', 'estoque', 'Rem voluptas vel nihil qui.', '1', '0', 'INM-73228524', '2030-12-31', 'Koelpin-Bosco', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(122, NULL, 'HM-38772577', 'SR-05675245', 'Elster', 'M-204', '25mm', 'Unijato / Velocidade', 'Classe A', '5.38', '49.16', '0.17', '2004', '2021-01-12', 'Eichmann-Rath', 'NF-21427764', 'estoque', 'Officiis veritatis sit dolor sed sit nemo.', '1', '0', 'INM-00101404', '2030-12-31', 'Ziemann Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(123, 36, 'HM-52502174', 'SR-73184251', 'Itron', 'M-359', '20mm', 'Woltman', 'Classe B', '4.26', '16.42', '0.23', '1990', '2018-01-05', 'Hartmann-Witting', 'NF-66096468', 'instalado', 'Sed voluptatibus excepturi laborum dolorem.', '1', '1', 'INM-92244512', '2030-12-31', 'Douglas-Johnson', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(124, 10, 'HM-68056835', 'SR-20594243', 'Arad', 'M-080', '15mm', 'Multijato', 'Classe B', '8.94', '17.9', '0.41', '2010', '1983-04-19', 'Hickle-Mayer', 'NF-39288752', 'instalado', 'Nam excepturi dolor minima autem tempora omnis.', '0', '1', 'INM-19750421', '2030-12-31', 'Blick-Jones', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(125, NULL, 'HM-96400818', 'SR-41371919', 'Elster', 'M-557', '20mm', 'Unijato / Velocidade', 'Classe C', '7.71', '32.66', '1', '1987', '1984-04-17', 'Wehner, Medhurst and Wolff', 'NF-63092506', 'estoque', 'Praesentium illum consequatur soluta officiis sed.', '0', '0', 'INM-55673624', '2030-12-31', 'Quigley, McLaughlin and Satterfield', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(126, NULL, 'HM-98955514', 'SR-09334869', 'Arad', 'M-325', '20mm', 'Woltman', 'Classe A', '9.31', '11.78', '0.91', '2021', '1974-09-27', 'Schimmel, Smith and Grimes', 'NF-20628376', 'estoque', 'Corrupti doloremque numquam consequatur inventore iusto.', '1', '0', 'INM-23117352', '2030-12-31', 'Will-Koepp', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(127, NULL, 'HM-72154220', 'SR-31178884', 'Zenner', 'M-290', '15mm', 'Multijato', 'Classe B', '5.6', '30.55', '0.94', '1973', '2011-02-13', 'Tremblay Group', 'NF-29120038', 'estoque', 'Nihil deleniti numquam molestias laborum praesentium.', '1', '1', 'INM-27856189', '2030-12-31', 'Lynch, Lehner and Wyman', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(128, 69, 'HM-63582886', 'SR-64038985', 'Zenner', 'M-142', '25mm', 'Unijato / Velocidade', 'Classe B', '5.33', '33.91', '0.71', '1972', '2013-09-09', 'Denesik-Doyle', 'NF-21976181', 'instalado', 'Libero voluptatibus consequatur earum aut doloribus.', '1', '0', 'INM-12403902', '2030-12-31', 'Ritchie, Thompson and Jacobson', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(129, 73, 'HM-46241515', 'SR-19666170', 'Arad', 'M-892', '25mm', 'Woltman', 'Classe C', '8.06', '45.43', '0.52', '2023', '2013-07-30', 'Brown, Predovic and Block', 'NF-32883757', 'instalado', 'Tenetur temporibus sit officia facilis quia dolores non.', '0', '0', 'INM-88789582', '2030-12-31', 'Wiza, Bechtelar and Conroy', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(130, 71, 'HM-80528996', 'SR-22170074', 'Itron', 'M-077', '15mm', 'Woltman', 'Classe C', '8.24', '37.19', '0.56', '1996', '1973-10-07', 'Denesik Group', 'NF-39721304', 'instalado', 'Deleniti est mollitia assumenda ut.', '1', '0', 'INM-95301528', '2030-12-31', 'Satterfield-O\'Kon', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(131, 57, 'HM-36363482', 'SR-67889909', 'Itron', 'M-590', '20mm', 'Unijato / Velocidade', 'Classe B', '6.63', '17.85', '0.86', '1993', '1979-05-01', 'Hills LLC', 'NF-71095169', 'instalado', 'Possimus explicabo et consequatur mollitia laboriosam autem.', '0', '1', 'INM-37110983', '2030-12-31', 'Beatty Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(132, NULL, 'HM-76140606', 'SR-68820650', 'Elster', 'M-405', '20mm', 'Unijato / Velocidade', 'Classe C', '2.87', '41.42', '0.55', '1991', '2010-08-06', 'Feest, O\'Keefe and Zieme', 'NF-29101179', 'estoque', 'A sint consequatur sit.', '1', '1', 'INM-40562426', '2030-12-31', 'Lockman Ltd', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(133, 70, 'HM-11035292', 'SR-90524000', 'Arad', 'M-420', '25mm', 'Unijato / Velocidade', 'Classe A', '6.93', '34.32', '0.96', '2008', '2002-07-24', 'Heaney, Crona and Rempel', 'NF-36183042', 'instalado', 'Qui sint accusamus earum nisi perspiciatis omnis odit.', '0', '1', 'INM-24949060', '2030-12-31', 'Johns, Schultz and Medhurst', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(134, NULL, 'HM-78430269', 'SR-60270676', 'Arad', 'M-449', '15mm', 'Unijato / Velocidade', 'Classe B', '5.6', '17.93', '0.48', '2018', '2012-09-01', 'Ondricka-Bogisich', 'NF-09851498', 'estoque', 'Nam iste a dicta harum hic laudantium.', '0', '1', 'INM-51669968', '2030-12-31', 'Bins-Satterfield', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(135, NULL, 'HM-08543398', 'SR-15320758', 'Arad', 'M-777', '20mm', 'Multijato', 'Classe C', '5.52', '37', '0.54', '2006', '2006-06-02', 'Nitzsche, Kirlin and Jones', 'NF-82325859', 'estoque', 'Quo molestiae repellat facere recusandae.', '0', '0', 'INM-27478734', '2030-12-31', 'Funk-Funk', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(136, 43, 'HM-02400741', 'SR-23834869', 'Itron', 'M-808', '25mm', 'Multijato', 'Classe B', '6.62', '34.78', '0.62', '1998', '2024-03-28', 'Bayer Group', 'NF-09609317', 'instalado', 'Et vero aut rerum itaque magni.', '1', '1', 'INM-63548228', '2030-12-31', 'Nitzsche, Reichel and Wunsch', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(137, 8, 'HM-52597537', 'SR-99151500', 'Zenner', 'M-186', '25mm', 'Unijato / Velocidade', 'Classe A', '5.74', '15.87', '0.86', '2002', '1978-01-18', 'Streich, Cronin and Price', 'NF-24490467', 'instalado', 'Qui ut sit omnis adipisci praesentium minus.', '1', '0', 'INM-10261973', '2030-12-31', 'Abernathy-Kuhn', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(138, 33, 'HM-15670077', 'SR-64714955', 'Arad', 'M-535', '15mm', 'Unijato / Velocidade', 'Classe C', '6.92', '28.48', '0.31', '1985', '2001-07-22', 'Rowe Group', 'NF-48419878', 'instalado', 'Aut minima cupiditate libero atque.', '0', '0', 'INM-61343852', '2030-12-31', 'Williamson, Smitham and Funk', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(139, 75, 'HM-95240166', 'SR-78386406', 'Elster', 'M-187', '25mm', 'Multijato', 'Classe A', '6.04', '11.54', '0.85', '2009', '1974-08-11', 'Roberts, Miller and Tremblay', 'NF-49706473', 'instalado', 'Ipsa consequatur consectetur facere molestias vel.', '0', '1', 'INM-33118144', '2030-12-31', 'McKenzie, Towne and Williamson', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38'),
(140, NULL, 'HM-96015401', 'SR-06346808', 'Elster', 'M-224', '15mm', 'Woltman', 'Classe C', '1.91', '38.93', '0.58', '1981', '2023-07-29', 'Lemke, Kris and Luettgen', 'NF-52086061', 'estoque', 'Asperiores placeat et vel eum repudiandae ipsa.', '0', '0', 'INM-41271449', '2030-12-31', 'Stroman, Schuster and Nitzsche', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(141, NULL, 'HM-27516276', 'SR-41544826', 'Elster', 'M-584', '15mm', 'Unijato / Velocidade', 'Classe C', '4.07', '35.14', '0.72', '2014', '1979-02-06', 'Wisozk, Kuhic and McGlynn', 'NF-94973633', 'estoque', 'Itaque et asperiores neque aperiam.', '0', '0', 'INM-42728060', '2030-12-31', 'Hills LLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(142, 62, 'HM-16012931', 'SR-91788130', 'Zenner', 'M-752', '15mm', 'Multijato', 'Classe C', '7.44', '28.79', '0.38', '1981', '1999-12-11', 'Towne-Kemmer', 'NF-65840803', 'instalado', 'Non quo consequatur nemo et minima similique maiores.', '0', '0', 'INM-44728965', '2030-12-31', 'Lebsack, Hyatt and West', 1, '2026-05-18 13:07:36', '2026-05-18 13:26:38');
INSERT INTO `medidores` (`id`, `cliente_id`, `numero_hidrometro`, `numero_serie`, `marca`, `modelo`, `diametro`, `tipo_hidrometro`, `classe_metrologica`, `qn`, `qmax`, `qmin`, `ano_fabricacao`, `data_aquisicao`, `fornecedor`, `nota_fiscal`, `status_inicial`, `observacoes`, `certificado_calibracao`, `laudo_inmetro`, `numero_certificado_inmetro`, `validade_certificado`, `laboratorio_calibracao`, `quantidade`, `created_at`, `updated_at`) VALUES
(143, 54, 'HM-12839655', 'SR-09179110', 'Zenner', 'M-762', '20mm', 'Unijato / Velocidade', 'Classe C', '5.86', '17.02', '0.89', '1981', '2003-03-02', 'Lubowitz-Schowalter', 'NF-48649236', 'instalado', 'Mollitia qui magnam rerum inventore qui consectetur commodi.', '0', '1', 'INM-11957624', '2030-12-31', 'Gorczany Inc', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:51'),
(144, 13, 'HM-08085269', 'SR-01540815', 'Zenner', 'M-381', '15mm', 'Unijato / Velocidade', 'Classe B', '2.04', '48.67', '0.51', '2014', '2002-06-04', 'Kautzer PLC', 'NF-15195106', 'instalado', 'Nam et perspiciatis iste magnam deleniti saepe.', '0', '0', 'INM-26469606', '2030-12-31', 'Lehner PLC', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(145, NULL, 'HM-10392291', 'SR-28235681', 'Elster', 'M-135', '15mm', 'Unijato / Velocidade', 'Classe C', '3.21', '28.5', '0.37', '2016', '2021-08-02', 'Jenkins LLC', 'NF-73387051', 'estoque', 'Placeat quo hic dolorum recusandae voluptatum perferendis est minima.', '0', '1', 'INM-95620908', '2030-12-31', 'Buckridge, Schoen and Terry', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(146, NULL, 'HM-54247281', 'SR-54890743', 'Arad', 'M-560', '20mm', 'Unijato / Velocidade', 'Classe A', '7.7', '25.96', '0.91', '1994', '2021-05-05', 'Bednar-Lehner', 'NF-86418110', 'estoque', 'Nulla blanditiis illo laudantium sit.', '0', '1', 'INM-30970869', '2030-12-31', 'Runte, Dickinson and Schneider', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(147, NULL, 'HM-18153562', 'SR-20803118', 'Itron', 'M-727', '15mm', 'Unijato / Velocidade', 'Classe A', '6.33', '35.79', '0.86', '2021', '1985-05-04', 'Hirthe, Satterfield and Koch', 'NF-89087257', 'estoque', 'Tempore incidunt et maxime et ullam.', '0', '0', 'INM-20552925', '2030-12-31', 'Effertz, Klein and Turner', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(148, 29, 'HM-88803445', 'SR-94844639', 'Itron', 'M-675', '20mm', 'Woltman', 'Classe A', '6.16', '34.84', '0.53', '1997', '1981-06-11', 'Roob, Bernhard and Nicolas', 'NF-97222907', 'instalado', 'Odio et illo quas quis perferendis.', '0', '0', 'INM-92691249', '2030-12-31', 'Gutkowski, Bashirian and Boehm', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50'),
(149, NULL, 'HM-86853330', 'SR-82419847', 'Elster', 'M-202', '20mm', 'Woltman', 'Classe C', '2.8', '35.09', '0.1', '2022', '1978-10-12', 'Bergnaum LLC', 'NF-12114615', 'estoque', 'Sit enim praesentium omnis aliquid qui et velit.', '1', '1', 'INM-55312651', '2030-12-31', 'Hoeger, D\'Amore and Schoen', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(150, NULL, 'HM-03259994', 'SR-89106068', 'Arad', 'M-672', '20mm', 'Multijato', 'Classe C', '3.55', '29.85', '0.24', '1985', '2016-03-18', 'Leuschke-Block', 'NF-79147874', 'estoque', 'Dolorem autem architecto sapiente beatae est ullam eius voluptas.', '1', '0', 'INM-62350794', '2030-12-31', 'Mueller, Berge and Connelly', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(151, NULL, 'HM-39978142', 'SR-95250337', 'Arad', 'M-822', '25mm', 'Unijato / Velocidade', 'Classe A', '7.62', '35.19', '0.62', '2005', '1982-05-27', 'Keebler Inc', 'NF-78206381', 'estoque', 'In optio necessitatibus eum voluptatum.', '1', '0', 'INM-74983482', '2030-12-31', 'Hills and Sons', 1, '2026-05-18 13:07:36', '2026-05-18 13:07:36'),
(152, 12, 'HM-72151581', 'SR-90307514', 'Zenner', 'M-591', '25mm', 'Multijato', 'Classe A', '8.41', '37.06', '0.8', '1974', '2024-10-25', 'Schultz, Fay and Mayer', 'NF-30616526', 'instalado', 'Expedita quidem consequatur sit debitis.', '1', '1', 'INM-37980786', '2030-12-31', 'Brekke-Gibson', 1, '2026-05-18 13:07:36', '2026-05-18 13:25:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_08_150114_create_permission_tables', 2),
(5, '2026_05_08_150535_create_activity_log_table', 3),
(6, '2026_05_08_150536_add_event_column_to_activity_log_table', 3),
(7, '2026_05_08_150537_add_batch_uuid_column_to_activity_log_table', 3),
(8, '2026_05_10_105524_add_extra_fields_to_permissions_table', 4),
(9, '2026_05_10_210720_add_extra_fields_to_roles_table', 5),
(10, '2026_05_11_141502_create_companies_table', 6),
(11, '2026_05_11_175708_create_tarifas_table', 7),
(12, '2026_05_11_175939_create_configuracao_financeiras_table', 8),
(13, '2026_05_11_180147_create_notificacao_configuracaos_table', 9),
(14, '2026_05_11_194855_configuracoes_financeiras', 10),
(15, '2026_05_11_222042_create_backup_configuracaos_table', 11),
(16, '2026_05_11_222215_create_backup_historicos_table', 11),
(17, '2026_05_12_112427_add_extra_fields_to_users_add_table', 12),
(18, '2026_05_12_183007_create_medidores_table', 13),
(19, '2026_05_12_212105_create_clientes_table', 14),
(20, '2026_05_12_212556_create_cliente_medidors_table', 15),
(21, '2026_05_13_101505_create_leituras_table', 16),
(22, '2026_05_14_213416_create_faturas_table', 17),
(23, '2026_05_14_213546_create_pagamentos_table', 17),
(24, '2026_05_15_115955_create_negociar_faturas_table', 18),
(25, '2026_05_15_120700_create_negociar_fatura_itens_table', 19),
(26, '2026_05_16_111725_create_roteiro_leituristas_table', 20),
(27, '2026_05_22_102259_create_configuracoes_app_table', 21),
(28, '2026_06_01_102238_create_documento_historicos_table', 22),
(29, '2026_06_16_111725_create_roteiro_leituristas_table', 23),
(30, '2026_07_08_171549_create_relatorios_table', 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(11, 'App\\Models\\User', 2),
(18, 'App\\Models\\User', 2),
(19, 'App\\Models\\User', 2),
(20, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 2),
(6, 'App\\Models\\User', 3),
(6, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao_configuracaos`
--

CREATE TABLE `notificacao_configuracaos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_vencimento` tinyint(1) NOT NULL DEFAULT 1,
  `dias_antes_vencimento` int(11) NOT NULL DEFAULT 3,
  `sms_atraso` tinyint(1) NOT NULL DEFAULT 1,
  `dias_atraso_sms` int(11) NOT NULL DEFAULT 5,
  `consumo_anomalo` tinyint(1) NOT NULL DEFAULT 1,
  `percentual_consumo_anomalo` int(11) NOT NULL DEFAULT 150,
  `novo_cadastro` tinyint(1) NOT NULL DEFAULT 0,
  `relatorio_semanal` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `notificacao_configuracaos`
--

INSERT INTO `notificacao_configuracaos` (`id`, `email_vencimento`, `dias_antes_vencimento`, `sms_atraso`, `dias_atraso_sms`, `consumo_anomalo`, `percentual_consumo_anomalo`, `novo_cadastro`, `relatorio_semanal`, `created_at`, `updated_at`) VALUES
(1, 0, 3, 0, 5, 0, 150, 0, 0, '2026-05-11 17:52:21', '2026-05-11 18:20:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fatura_id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `codigo_transacao` varchar(255) DEFAULT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `saldo_restante` varchar(255) DEFAULT NULL,
  `data_pagamento` date NOT NULL,
  `hora_pagamento` time DEFAULT NULL,
  `metodo_pagamento` enum('Mpesa','Emola','Dinheiro','Transferencia','Cartao','Debito_Conta') NOT NULL,
  `numero_comprovante` varchar(255) DEFAULT NULL,
  `status` enum('Pendente','Parcial','Confirmado','Estornado','Cancelado') NOT NULL DEFAULT 'Confirmado',
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `fatura_id`, `cliente_id`, `user_id`, `codigo_transacao`, `valor_pago`, `saldo_restante`, `data_pagamento`, `hora_pagamento`, `metodo_pagamento`, `numero_comprovante`, `status`, `observacoes`, `created_at`, `updated_at`) VALUES
(1, 19, 72, 1, 'TRX-6A526E9B750D5-43DE', 1500.00, NULL, '2026-07-11', '16:34:09', 'Dinheiro', 'COMP-20260711-940581', 'Confirmado', '', '2026-07-11 14:34:09', '2026-07-11 14:34:09'),
(2, 1, 79, 1, 'TRX-6A52752BE9A6E-F800', 390.00, '390', '2026-07-11', '16:55:03', 'Dinheiro', 'COMP-20260711-102554', 'Confirmado', '', '2026-07-11 14:55:03', '2026-07-11 14:55:03'),
(3, 1, 79, 1, 'TRX-6A52766ED88B0-E592', 390.00, '0', '2026-07-11', '17:00:10', 'Mpesa', 'COMP-20260711-890898', 'Confirmado', '', '2026-07-11 15:00:10', '2026-07-11 15:00:10'),
(4, 2, 40, 1, 'TRX-6A527DB0741EF-9FF4', 1350.00, '450', '2026-07-11', '17:30:34', 'Dinheiro', 'COMP-20260711-150509', 'Confirmado', '', '2026-07-11 15:30:34', '2026-07-11 15:30:34'),
(5, 2, 40, 1, 'TRX-6A527E22607F9-09F5', 450.00, '0', '2026-07-11', '17:32:24', 'Dinheiro', 'COMP-20260711-896600', 'Confirmado', '', '2026-07-11 15:32:24', '2026-07-11 15:32:24'),
(23, 20, 69, 1, 'TRX-6A52825483E41-89A3', 742.50, '247,5', '2026-07-11', '17:50:22', 'Dinheiro', 'COMP-20260711-223479', 'Confirmado', '', '2026-07-11 15:50:22', '2026-07-11 15:50:22'),
(24, 20, 69, 1, 'TRX-6A528493ECEB6-C637', 247.50, '0', '2026-07-11', '18:00:02', 'Dinheiro', 'COMP-20260711-201400', 'Confirmado', '', '2026-07-11 16:00:02', '2026-07-11 16:00:02'),
(25, 3, 70, 1, 'TRX-6A5284CCDBC0F-6031', 536.25, '178.75', '2026-07-11', '18:01:06', 'Dinheiro', 'COMP-20260711-455259', 'Confirmado', '', '2026-07-11 16:01:06', '2026-07-11 16:01:06'),
(26, 3, 70, 1, 'TRX-6A528518BA13A-4716', 44.69, '134.06', '2026-07-11', '18:02:12', 'Mpesa', 'COMP-20260711-793293', 'Confirmado', '', '2026-07-11 16:02:12', '2026-07-11 16:02:12'),
(27, 3, 70, 1, 'TRX-6A528593C30D8-7D4F', 100.55, '33.51', '2026-07-11', '18:04:15', 'Dinheiro', 'COMP-20260711-122603', 'Confirmado', '', '2026-07-11 16:04:15', '2026-07-11 16:04:15'),
(28, 3, 70, 1, 'TRX-6A5285D1F1703-7391', 25.13, '8.38', '2026-07-11', '18:05:15', 'Dinheiro', 'COMP-20260711-986072', 'Confirmado', '', '2026-07-11 16:05:15', '2026-07-11 16:05:15'),
(29, 3, 70, 1, 'TRX-6A528AB5D7C49-14FB', 8.38, '0', '2026-07-11', '18:26:54', 'Dinheiro', 'COMP-20260711-173836', 'Confirmado', '', '2026-07-11 16:26:54', '2026-07-11 16:26:54'),
(30, 21, 65, 1, 'TRX-6A52AB232FE71-2388', 990.00, '330', '2026-07-11', '20:44:30', 'Dinheiro', 'COMP-20260711-547032', 'Confirmado', '', '2026-07-11 18:44:30', '2026-07-11 18:44:30'),
(31, 21, 65, 1, 'TRX-6A52AB40DADC9-4942', 247.50, '82.5', '2026-07-11', '20:44:57', 'Mpesa', 'COMP-20260711-872388', 'Confirmado', '', '2026-07-11 18:44:57', '2026-07-11 18:44:57'),
(32, 21, 65, 1, 'TRX-6A52B0C93BE63-E323', 41.25, '41.25', '2026-07-11', '21:08:32', 'Dinheiro', 'COMP-20260711-815562', 'Confirmado', '', '2026-07-11 19:08:32', '2026-07-11 19:08:32'),
(33, 21, 65, 1, 'TRX-6A52B11C3CB7E-10A2', 20.63, '20.62', '2026-07-11', '21:09:54', 'Dinheiro', 'COMP-20260711-391462', 'Confirmado', '', '2026-07-11 19:09:54', '2026-07-11 19:09:54'),
(34, 21, 65, 1, 'TRX-6A52B14AA2FF4-1E00', 15.46, '5.1600000000001', '2026-07-11', '21:10:42', 'Dinheiro', 'COMP-20260711-916401', 'Confirmado', '', '2026-07-11 19:10:42', '2026-07-11 19:10:42'),
(35, 21, 65, 1, 'TRX-6A52B19174476-2E87', 2.58, '2.5799999999999', '2026-07-11', '21:11:51', 'Dinheiro', 'COMP-20260711-332990', 'Confirmado', '', '2026-07-11 19:11:51', '2026-07-11 19:11:51'),
(36, 4, 25, 1, 'TRX-6A53426225441-2DA5', 650.00, '0', '2026-07-12', '07:30:11', 'Dinheiro', 'COMP-20260712-804136', 'Confirmado', '', '2026-07-12 05:30:11', '2026-07-12 05:30:11'),
(37, 21, 65, 1, 'TRX-6A53470950304-4CFA', 2.58, '0', '2026-07-12', '07:49:45', 'Dinheiro', 'COMP-20260712-438036', 'Confirmado', '', '2026-07-12 05:49:45', '2026-07-12 05:49:45'),
(38, 22, 32, 1, 'TRX-6A53474CCFA1E-232A', 357.50, '1072.5', '2026-07-12', '07:50:44', 'Dinheiro', 'COMP-20260712-461885', 'Confirmado', '', '2026-07-12 05:50:44', '2026-07-12 05:50:44'),
(39, 22, 32, 1, 'TRX-6A5348021AADE-93AC', 268.13, '804.37', '2026-07-12', '07:53:45', 'Dinheiro', 'COMP-20260712-991198', 'Confirmado', '', '2026-07-12 05:53:45', '2026-07-12 05:53:45'),
(40, 22, 32, 1, 'TRX-6A53487398930-2884', 201.09, '603.28', '2026-07-12', '07:55:45', 'Dinheiro', 'COMP-20260712-625562', 'Confirmado', '', '2026-07-12 05:55:45', '2026-07-12 05:55:45'),
(41, 22, 32, 1, 'TRX-6A5348A4B4069-0E99', 150.82, '452.46', '2026-07-12', '07:56:28', 'Dinheiro', 'COMP-20260712-878691', 'Confirmado', '', '2026-07-12 05:56:28', '2026-07-12 05:56:28'),
(42, 22, 32, 1, 'TRX-6A5348D8C93C8-26B9', 113.12, '339.34', '2026-07-12', '07:57:18', 'Dinheiro', 'COMP-20260712-297905', 'Confirmado', '', '2026-07-12 05:57:18', '2026-07-12 05:57:18'),
(43, 23, 60, 1, 'TRX-6A53934041DD9-8839', 1800.00, '0', '2026-07-12', '13:14:52', 'Dinheiro', 'COMP-20260712-128766', 'Confirmado', '', '2026-07-12 11:14:52', '2026-07-12 11:14:52'),
(44, 22, 32, 1, 'TRX-6A53B617DE879-9C21', 84.84, '254.5', '2026-07-12', '15:43:26', 'Dinheiro', 'COMP-20260712-657142', 'Confirmado', '', '2026-07-12 13:43:26', '2026-07-12 13:43:26'),
(45, 22, 32, 1, 'TRX-6A53B9306C0D8-921E', 63.63, '190.87', '2026-07-12', '15:56:37', 'Dinheiro', 'COMP-20260712-235609', 'Confirmado', '', '2026-07-12 13:56:37', '2026-07-12 13:56:37'),
(46, 22, 32, 1, 'TRX-6A53C37C61074-900D', 190.87, '0', '2026-07-12', '16:40:36', 'Dinheiro', 'COMP-20260712-448559', 'Confirmado', '', '2026-07-12 14:40:36', '2026-07-12 14:40:36'),
(47, 24, 36, 1, 'TRX-6A53C91950103-1473', 450.00, '450', '2026-07-12', '17:04:36', 'Dinheiro', 'COMP-20260712-121418', 'Confirmado', '', '2026-07-12 15:04:36', '2026-07-12 15:04:36'),
(48, 25, 30, 1, 'TRX-6A57D276DD283-2A8B', 1800.00, '0', '2026-07-15', '18:33:36', 'Dinheiro', 'COMP-20260715-891502', 'Confirmado', '', '2026-07-15 16:33:36', '2026-07-15 16:33:36'),
(49, 24, 36, 1, 'TRX-6A57D3B3AA23A-BD45', 225.00, '225', '2026-07-15', '18:38:51', 'Dinheiro', 'COMP-20260715-117729', 'Confirmado', '', '2026-07-15 16:38:51', '2026-07-15 16:38:51'),
(50, 24, 36, 1, 'TRX-6A57D428F1759-BF2C', 225.00, '0', '2026-07-15', '18:40:47', 'Dinheiro', 'COMP-20260715-322693', 'Confirmado', '', '2026-07-15 16:40:47', '2026-07-15 16:40:47'),
(51, 53, 13, 1, 'TRX-6A5E150E579FB-0035', 201.00, '603', '2026-07-20', '12:31:18', 'Dinheiro', 'COMP-20260720-693585', 'Confirmado', '', '2026-07-20 10:31:18', '2026-07-20 10:31:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `display_name`, `module`, `description`) VALUES
(11, 'clientes.create', 'web', '2026-05-10 14:26:06', '2026-05-10 14:26:06', 'Cliente Create', 'Clientes', 'esf sf'),
(12, 'dashboard.ver', 'web', '2026-05-10 15:20:03', '2026-05-10 15:20:03', 'Ver Dashboard', 'Dashboard', 'Permite entrar e ver a pagina dashboad '),
(14, 'medidores.create', 'web', '2026-05-10 21:01:59', '2026-05-10 21:01:59', 'Criar Medidores', 'Medidores', 'Permite cria medidores '),
(15, 'medidores.editar', 'web', '2026-05-10 21:05:36', '2026-05-10 21:05:36', 'Editar Medidores', 'Medidores', 'Permite editar os medidores'),
(16, 'usuarios.create', 'web', '2026-05-10 21:06:29', '2026-05-10 21:06:29', 'Criar Usuarios', 'Usuarios', 'Permite Criar usuarios'),
(17, 'usuarios.editar', 'web', '2026-05-10 21:08:37', '2026-05-10 21:08:37', 'Editar Usuarios', 'Usuarios', 'Permite Editar Usuarios '),
(18, 'leituras.editar', 'web', '2026-05-10 22:28:34', '2026-05-10 22:28:34', 'Editar Leituras ', 'Leituras', 'Permite editar Leituras Lancadas'),
(19, 'leituras.gerarfaturas', 'web', '2026-05-10 22:29:53', '2026-05-10 22:29:53', 'Gerar Faturas ', 'Leituras', 'Permite gerar fatura das leituras'),
(20, 'leituras.create', 'web', '2026-05-10 22:30:42', '2026-05-10 22:30:42', 'Criar Leitura', 'Leituras', 'Permite adicionar nova ou cria leitura'),
(21, 'medidores.deletar', 'web', '2026-06-01 18:52:35', '2026-06-01 18:52:35', 'Deletar Medidores', 'Medidores', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios`
--

CREATE TABLE `relatorios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fatura_id` int(11) DEFAULT NULL,
  `pagamentos_id` int(11) DEFAULT NULL,
  `origem` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `data_referencia` varchar(255) NOT NULL,
  `ficheiro_caminho` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `relatorios`
--

INSERT INTO `relatorios` (`id`, `cliente_id`, `fatura_id`, `pagamentos_id`, `origem`, `user_id`, `data_referencia`, `ficheiro_caminho`, `nome_arquivo`, `status`, `created_at`, `updated_at`) VALUES
(44, 32, 22, 40, 'Pagamentos-40', '1', '2026-07-12', 'pdfs/COMP-20260712-625562_32_Pagamentos-40.pdf', 'COMP-20260712-625562_32_Pagamentos-40.pdf', 'ativo', '2026-07-12 14:01:07', '2026-07-12 14:01:07'),
(45, 32, 22, 39, 'Pagamentos-39', '1', '2026-07-12', 'pdfs/COMP-20260712-991198_32_Pagamentos-39.pdf', 'COMP-20260712-991198_32_Pagamentos-39.pdf', 'ativo', '2026-07-12 14:01:20', '2026-07-12 14:01:20'),
(46, 32, 22, 41, 'Pagamentos-41', '1', '2026-07-12', 'pdfs/COMP-20260712-878691_32_Pagamentos-41.pdf', 'COMP-20260712-878691_32_Pagamentos-41.pdf', 'ativo', '2026-07-12 14:01:23', '2026-07-12 14:01:23'),
(47, 32, 22, 42, 'Pagamentos-42', '1', '2026-07-12', 'pdfs/COMP-20260712-297905_32_Pagamentos-42.pdf', 'COMP-20260712-297905_32_Pagamentos-42.pdf', 'ativo', '2026-07-12 14:01:41', '2026-07-12 14:01:41'),
(48, 32, 22, 45, 'Pagamentos-45', '1', '2026-07-12', 'pdfs/COMP-20260712-235609_32_Pagamentos-45.pdf', 'COMP-20260712-235609_32_Pagamentos-45.pdf', 'ativo', '2026-07-12 14:04:02', '2026-07-12 14:04:02'),
(49, 32, 22, 38, 'Pagamentos-38', '1', '2026-07-12', 'pdfs/COMP-20260712-461885_32_Pagamentos-38.pdf', 'COMP-20260712-461885_32_Pagamentos-38.pdf', 'ativo', '2026-07-12 14:06:01', '2026-07-12 14:06:01'),
(50, 65, 21, 32, 'Pagamentos-32', '1', '2026-07-11', 'pdfs/COMP-20260711-815562_65_Pagamentos-32.pdf', 'COMP-20260711-815562_65_Pagamentos-32.pdf', 'ativo', '2026-07-12 14:09:49', '2026-07-12 14:09:49'),
(51, 65, 21, 35, 'Pagamentos-35', '1', '2026-07-11', 'pdfs/COMP-20260711-332990_65_Pagamentos-35.pdf', 'COMP-20260711-332990_65_Pagamentos-35.pdf', 'ativo', '2026-07-12 14:10:12', '2026-07-12 14:10:12'),
(52, 70, 3, 27, 'Pagamentos-27', '1', '2026-07-11', 'pdfs/COMP-20260711-122603_70_Pagamentos-27.pdf', 'COMP-20260711-122603_70_Pagamentos-27.pdf', 'ativo', '2026-07-12 14:11:52', '2026-07-12 14:11:52'),
(53, 79, 1, 2, 'Pagamentos-2', '1', '2026-07-11', 'pdfs/COMP-20260711-102554_79_Pagamentos-2.pdf', 'COMP-20260711-102554_79_Pagamentos-2.pdf', 'ativo', '2026-07-12 14:13:43', '2026-07-12 14:13:43'),
(54, 69, 20, 23, 'Pagamentos-23', '1', '2026-07-11', 'pdfs/COMP-20260711-223479_69_Pagamentos-23.pdf', 'COMP-20260711-223479_69_Pagamentos-23.pdf', 'ativo', '2026-07-12 14:15:16', '2026-07-12 14:15:16'),
(55, 65, 21, 34, 'Pagamentos-34', '1', '2026-07-11', 'pdfs/COMP-20260711-916401_65_Pagamentos-34.pdf', 'COMP-20260711-916401_65_Pagamentos-34.pdf', 'ativo', '2026-07-12 14:17:58', '2026-07-12 14:17:58'),
(56, 40, 2, 4, 'Pagamentos-4', '1', '2026-07-11', 'pdfs/COMP-20260711-150509_40_Pagamentos-4.pdf', 'COMP-20260711-150509_40_Pagamentos-4.pdf', 'ativo', '2026-07-12 14:18:36', '2026-07-12 14:18:36'),
(57, 72, 19, 1, 'Pagamentos-1', '1', '2026-07-11', 'pdfs/COMP-20260711-940581_72_Pagamentos-1.pdf', 'COMP-20260711-940581_72_Pagamentos-1.pdf', 'ativo', '2026-07-12 14:18:39', '2026-07-12 14:18:39'),
(58, 70, 3, 29, 'Pagamentos-29', '1', '2026-07-11', 'pdfs/COMP-20260711-173836_70_Pagamentos-29.pdf', 'COMP-20260711-173836_70_Pagamentos-29.pdf', 'ativo', '2026-07-12 14:18:42', '2026-07-12 14:18:42'),
(59, 70, 3, 25, 'Pagamentos-25', '1', '2026-07-11', 'pdfs/COMP-20260711-455259_70_Pagamentos-25.pdf', 'COMP-20260711-455259_70_Pagamentos-25.pdf', 'ativo', '2026-07-12 14:22:15', '2026-07-12 14:22:15'),
(60, 79, 1, 3, 'Pagamentos-3', '1', '2026-07-11', 'pdfs/COMP-20260711-890898_79_Pagamentos-3.pdf', 'COMP-20260711-890898_79_Pagamentos-3.pdf', 'ativo', '2026-07-12 14:27:32', '2026-07-12 14:27:32'),
(61, 69, 20, 24, 'Pagamentos-24', '1', '2026-07-11', 'pdfs/COMP-20260711-201400_69_Pagamentos-24.pdf', 'COMP-20260711-201400_69_Pagamentos-24.pdf', 'ativo', '2026-07-12 14:36:25', '2026-07-12 14:36:25'),
(62, 65, 21, 31, 'Pagamentos-31', '1', '2026-07-11', 'pdfs/COMP-20260711-872388_65_Pagamentos-31.pdf', 'COMP-20260711-872388_65_Pagamentos-31.pdf', 'ativo', '2026-07-12 14:37:03', '2026-07-12 14:37:03'),
(63, 65, 21, 33, 'Pagamentos-33', '1', '2026-07-11', 'pdfs/COMP-20260711-391462_65_Pagamentos-33.pdf', 'COMP-20260711-391462_65_Pagamentos-33.pdf', 'ativo', '2026-07-12 14:38:52', '2026-07-12 14:38:52'),
(64, 70, 3, 28, 'Pagamentos-28', '1', '2026-07-11', 'pdfs/COMP-20260711-986072_70_Pagamentos-28.pdf', 'COMP-20260711-986072_70_Pagamentos-28.pdf', 'ativo', '2026-07-12 14:39:52', '2026-07-12 14:39:52'),
(65, 32, 22, 46, 'Pagamentos-46', '1', '2026-07-12', 'pdfs/COMP-20260712-448559_32_Pagamentos-46.pdf', 'COMP-20260712-448559_32_Pagamentos-46.pdf', 'ativo', '2026-07-12 14:40:37', '2026-07-12 14:40:37'),
(66, 65, 21, 37, 'Pagamentos-37', '1', '2026-07-12', 'pdfs/COMP-20260712-438036_65_Pagamentos-37.pdf', 'COMP-20260712-438036_65_Pagamentos-37.pdf', 'ativo', '2026-07-12 14:42:32', '2026-07-12 14:42:32'),
(67, 60, 23, 43, 'Pagamentos-43', '1', '2026-07-12', 'pdfs/COMP-20260712-128766_60_Pagamentos-43.pdf', 'COMP-20260712-128766_60_Pagamentos-43.pdf', 'ativo', '2026-07-12 14:43:25', '2026-07-12 14:43:25'),
(68, 36, 24, 47, 'Pagamentos-47', '1', '2026-07-12', 'pdfs/COMP-20260712-121418_36_Pagamentos-47.pdf', 'COMP-20260712-121418_36_Pagamentos-47.pdf', 'ativo', '2026-07-12 15:04:37', '2026-07-12 15:04:37'),
(69, 30, 25, 48, 'Pagamentos-48', '1', '2026-07-15', 'pdfs/COMP-20260715-891502_30_Pagamentos-48.pdf', 'COMP-20260715-891502_30_Pagamentos-48.pdf', 'ativo', '2026-07-15 16:33:38', '2026-07-15 16:33:38'),
(70, 36, 24, 49, 'Pagamentos-49', '1', '2026-07-15', 'pdfs/COMP-20260715-117729_36_Pagamentos-49.pdf', 'COMP-20260715-117729_36_Pagamentos-49.pdf', 'ativo', '2026-07-15 16:38:52', '2026-07-15 16:38:52'),
(71, 36, 24, 50, 'Pagamentos-50', '1', '2026-07-15', 'pdfs/COMP-20260715-322693_36_Pagamentos-50.pdf', 'COMP-20260715-322693_36_Pagamentos-50.pdf', 'ativo', '2026-07-15 16:40:47', '2026-07-15 16:40:47'),
(72, 13, 53, 51, 'Pagamentos-51', '1', '2026-07-20', 'pdfs/COMP-20260720-693585_13_Pagamentos-51.pdf', 'COMP-20260720-693585_13_Pagamentos-51.pdf', 'ativo', '2026-08-10 06:41:18', '2026-08-10 06:41:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `color` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `slug`, `color`, `description`) VALUES
(1, 'Super Admin', 'web', '2026-05-10 10:35:56', '2026-05-10 10:35:56', 'super-admin', 'danger', 'Gestão operacional completa. Pode cadastrar e editar clientes, medidores, faturas e leituras.'),
(3, 'Admin', 'web', '2026-05-10 19:58:34', '2026-05-11 09:00:13', 'admin', 'primary', 'Gestão particial completa. Pode cadastrar e editar clientes, medidores, faturas e leituras.'),
(4, 'Financeiro', 'web', '2026-05-10 20:23:19', '2026-05-11 09:01:03', 'financeiro', 'warning', 'Gestão de clientes. Pode cadastrar e editar clientes, medidores, faturas e pagamentos.'),
(6, 'Leiturista', 'web', '2026-05-10 20:46:00', '2026-05-10 20:46:00', 'leiturista', 'purple', 'O presente Role permite o cadastro e a gestao das leituras '),
(7, 'Gerente Medidores', 'web', '2026-06-01 18:51:44', '2026-06-01 18:51:44', 'gerente-medidores', 'success', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(11, 1),
(11, 3),
(11, 4),
(11, 7),
(12, 1),
(12, 3),
(12, 4),
(12, 7),
(14, 1),
(14, 3),
(14, 4),
(14, 7),
(15, 1),
(15, 3),
(15, 4),
(15, 7),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(18, 1),
(18, 6),
(19, 1),
(19, 6),
(20, 1),
(20, 6),
(21, 1),
(21, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `roteiro_leituristas`
--

CREATE TABLE `roteiro_leituristas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fatura_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `data_referente` date NOT NULL,
  `leitura_anterior` decimal(10,2) NOT NULL DEFAULT 0.00,
  `leitura_atual` decimal(10,2) DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `Zona` varchar(255) DEFAULT NULL,
  `status` enum('Pendente','Em andamento','Concluido','Não lido','Problema') NOT NULL DEFAULT 'Pendente',
  `observacoes` text DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lido_em` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `roteiro_leituristas`
--

INSERT INTO `roteiro_leituristas` (`id`, `user_id`, `fatura_id`, `cliente_id`, `data_referente`, `leitura_anterior`, `leitura_atual`, `data_inicio`, `data_fim`, `Zona`, `status`, `observacoes`, `ordem`, `foto`, `lido_em`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 79, '2026-07-09', 0.00, 12.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Concluido', '', 1, NULL, '2026-07-08 22:00:00', 1, '2026-07-09 10:31:37', '2026-07-09 10:32:18'),
(2, 6, 2, 40, '2026-07-09', 0.00, 12.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Concluido', '', 2, NULL, '2026-07-10 22:00:00', 1, '2026-07-09 10:31:37', '2026-07-11 15:29:34'),
(3, 6, 3, 70, '2026-07-09', 0.00, 11.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Concluido', '', 3, NULL, '2026-07-10 22:00:00', 1, '2026-07-09 10:31:37', '2026-07-11 16:00:30'),
(4, 6, 4, 25, '2026-07-09', 0.00, 10.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Concluido', '', 4, NULL, '2026-07-11 22:00:00', 1, '2026-07-09 10:31:37', '2026-07-12 05:28:51'),
(5, 6, 5, 5, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 5, NULL, NULL, 1, '2026-07-09 10:31:37', '2026-07-09 10:31:37'),
(6, 6, 6, 62, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 6, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(7, 6, 7, 74, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 7, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(8, 6, 8, 64, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 8, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(9, 6, 9, 22, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 9, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(10, 6, 10, 9, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 10, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(11, 6, 11, 53, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 11, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(12, 6, 12, 35, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 12, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(13, 6, 13, 38, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 13, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(14, 6, 14, 58, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 14, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(15, 6, 15, 61, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 15, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(16, 6, 16, 12, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 16, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(17, 6, 17, 41, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 17, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(18, 6, 18, 37, '2026-07-09', 0.00, NULL, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Sul', 'Pendente', '', 18, NULL, NULL, 1, '2026-07-09 10:31:38', '2026-07-09 10:31:38'),
(19, 6, 19, 72, '2026-07-09', 0.00, 10.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Norte', 'Concluido', '', 1, NULL, '2026-07-10 22:00:00', 1, '2026-07-09 10:31:45', '2026-07-11 14:17:10'),
(20, 6, 20, 69, '2026-07-09', 0.00, 9.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Norte', 'Concluido', '', 2, NULL, '2026-07-10 22:00:00', 1, '2026-07-09 10:31:45', '2026-07-11 15:50:05'),
(21, 6, 21, 65, '2026-07-09', 0.00, 12.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Norte', 'Concluido', '', 3, NULL, '2026-07-10 22:00:00', 1, '2026-07-09 10:31:45', '2026-07-11 18:44:10'),
(22, 6, 22, 32, '2026-07-09', 0.00, 13.00, '2026-07-09 00:00:00', '2026-07-31 00:00:00', 'Zona Norte', 'Concluido', '', 4, NULL, '2026-07-11 22:00:00', 1, '2026-07-09 10:31:45', '2026-07-12 05:29:02'),
(23, 3, 23, 60, '2026-07-12', 0.00, 12.00, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Concluido', '', 1, NULL, '2026-07-11 22:00:00', 1, '2026-07-12 11:12:39', '2026-07-12 11:14:09'),
(24, 3, 24, 36, '2026-07-12', 0.00, 12.00, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Concluido', '', 2, NULL, '2026-07-11 22:00:00', 1, '2026-07-12 11:12:39', '2026-07-12 15:04:17'),
(25, 3, 25, 30, '2026-07-12', 0.00, 12.00, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Concluido', '', 3, NULL, '2026-07-14 22:00:00', 1, '2026-07-12 11:12:39', '2026-07-15 16:11:13'),
(26, 3, 26, 17, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 4, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(27, 3, 27, 73, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 5, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(28, 3, 28, 14, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 6, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(29, 3, 29, 59, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 7, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(30, 3, 30, 49, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 8, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(31, 3, 31, 10, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 9, NULL, NULL, 1, '2026-07-12 11:12:39', '2026-07-12 11:12:39'),
(32, 3, 32, 54, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 10, NULL, NULL, 1, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(33, 3, 33, 29, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 11, NULL, NULL, 1, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(34, 3, 34, 56, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 12, NULL, NULL, 1, '2026-07-12 11:12:40', '2026-07-12 11:12:40'),
(35, 3, 35, 48, '2026-07-12', 0.00, NULL, '2026-07-12 00:00:00', '2026-07-31 00:00:00', 'Zona Leste', 'Pendente', '', 13, NULL, NULL, 1, '2026-07-12 11:12:40', '2026-07-12 11:12:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9IA6IBYRvdlP1FfACmQK7nSAQOpiahzFgA4Z8eSq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTk5YdGxMUGRrOTgyVzB3NlFmN01lbEZLOUJKZk94ekt6bGtrM3RLRSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvTWVkaWRvcmVzP3N0YXR1c0ZpbHRlcj1Db3J0YWRhIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5tZWRpZG9yZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1784662485),
('bA9PGiVyUnZOCbaoxFz2eV4LpRB4pwsccigGd8h5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU3RwUm9MTmFzcnFucjEyNWlLMkdqWjZFZWZyNlg1dk9zcDhUY2pCQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvRmF0dXJhcyI7czo1OiJyb3V0ZSI7czoxMzoiYWRtaW4uZmF0dXJhcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1784578597),
('dP7vwA9EFjJbWY77msT0LyrQFXHVpr9ktZIM6pGk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnhHN25zaHlYUXZ3SWtpQ0NsaU5XNjg1Mmt4anp0bkF4T2dQSUtiWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9QYWdhbWVudG9zIjtzOjU6InJvdXRlIjtzOjE2OiJhZG1pbi5wYWdhbWVudG9zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1786351286);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarifas`
--

CREATE TABLE `tarifas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `valor_m3` decimal(10,2) NOT NULL,
  `taxa_minima` decimal(10,2) NOT NULL,
  `limite_m3` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tarifas`
--

INSERT INTO `tarifas` (`id`, `categoria`, `valor_m3`, `taxa_minima`, `limite_m3`, `created_at`, `updated_at`) VALUES
(9, 'Residencial', 75.00, 350.00, 5, '2026-05-11 18:20:56', '2026-07-12 05:52:35'),
(10, 'Comercial', 110.00, 550.00, 5, '2026-05-11 18:20:56', '2026-05-11 19:43:36'),
(11, 'Industrial', 150.00, 1050.00, 8, '2026-05-11 18:20:56', '2026-05-11 19:43:52'),
(12, 'Publico', 67.00, 250.00, 10, '2026-05-11 18:20:56', '2026-05-11 19:44:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `zona` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `motivos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `zona`, `telefone`, `status`, `motivos`) VALUES
(1, 'Chester Macoda', 'chestermacoda@gmail.com', NULL, '$2y$12$A2qTbzCRv5SUpqQYFE44YOHjCfkt7w.OF1.4FLbk9eL7kukuvVgT6', NULL, '2026-05-12 09:32:47', '2026-05-17 09:41:49', 'Todas as Zonas', '878107874', 'ativo', ''),
(2, 'leiturista joao', 'leiturista@gmail.com', NULL, '$2y$12$z/Nc8FwDvf9njvXsjFobA.15N/f4JgA43PhE9tWQu1dCDhJw4IFEe', NULL, '2026-05-12 09:34:48', '2026-07-09 08:29:02', 'Todas as Zonas', '878100007', 'ativo', NULL),
(3, 'leiturista 2', 'leiturista2@gmail.com', NULL, '$2y$12$FLTm4UlA.SbsvJHueKIq0./QvOgJ9VJRfhyBl1Vg1oXyXo/mTcJIS', NULL, '2026-05-12 09:36:16', '2026-07-09 08:31:40', 'Zona Norte', '871222220', 'ativo', ''),
(4, 'Leiturista 3', 'Leiturista3@gmail.com', NULL, '$2y$12$hN0XdUX8S7o5CUUA4ZlVwOmvfap0nU7TB0J.RdwSTxPQg9T/g1zK6', NULL, '2026-05-12 09:46:29', '2026-05-12 15:33:49', 'Zona Sul', '871231231232', 'ativo', ''),
(5, 'Administrador', 'admin@gmail.com', NULL, '$2y$12$I9DHnAh09tEjvf6lYkL7puMC87nOdN5C4N4gNauSPxw5iUN3X5/oa', NULL, '2026-05-12 09:56:21', '2026-05-17 18:03:11', 'Todas as Zonas', '874764312', 'ativo', ''),
(6, 'Joao Pascual', 'joao@gmail.com', NULL, '$2y$12$kNkfIFWbDiURqQK37UOtbeAe6iy.OF925sEkCbeImaaJGsHMawX.u', NULL, '2026-05-12 11:52:42', '2026-05-23 08:42:07', 'Zona Sul', '878121212', 'ativo', ''),
(7, 'Regina', 'regina@gmail.com', NULL, '$2y$12$ST3MXPkLF3VolqJe/BloyuggLN.tnfYFqfau3OMqweXNe1kaZ54wC', NULL, '2026-06-01 18:46:59', '2026-06-01 18:46:59', 'Todas as Zonas', '8712321312', 'ativo', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Índices para tabela `backup_configuracaos`
--
ALTER TABLE `backup_configuracaos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `backup_historicos`
--
ALTER TABLE `backup_historicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Índices para tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_bi_unique` (`bi`),
  ADD UNIQUE KEY `clientes_email_unique` (`email`),
  ADD UNIQUE KEY `clientes_numero_matricula_unique` (`numero_matricula`);

--
-- Índices para tabela `cliente_medidors`
--
ALTER TABLE `cliente_medidors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_medidors_cliente_id_foreign` (`cliente_id`),
  ADD KEY `cliente_medidors_medidor_id_foreign` (`medidor_id`);

--
-- Índices para tabela `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_cnpj_unique` (`cnpj`);

--
-- Índices para tabela `configuracao_financeiras`
--
ALTER TABLE `configuracao_financeiras`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `configuracoes_app`
--
ALTER TABLE `configuracoes_app`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configuracoes_app_user_id_foreign` (`user_id`);

--
-- Índices para tabela `documento_historicos`
--
ALTER TABLE `documento_historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documento_historicos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `documento_historicos_fatura_id_foreign` (`fatura_id`),
  ADD KEY `documento_historicos_pagamento_id_foreign` (`pagamento_id`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `faturas`
--
ALTER TABLE `faturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faturas_codigo_fatura_unique` (`codigo_fatura`),
  ADD KEY `faturas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `faturas_leitura_id_foreign` (`leitura_id`);

--
-- Índices para tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices para tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `leituras`
--
ALTER TABLE `leituras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leituras_medidores_id_foreign` (`medidores_id`),
  ADD KEY `leituras_user_id_foreign` (`user_id`),
  ADD KEY `leituras_editado_por_foreign` (`editado_por`),
  ADD KEY `leituras_cliente_id_foreign` (`cliente_id`);

--
-- Índices para tabela `medidores`
--
ALTER TABLE `medidores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medidores_numero_hidrometro_unique` (`numero_hidrometro`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices para tabela `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Índices para tabela `notificacao_configuracaos`
--
ALTER TABLE `notificacao_configuracaos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagamentos_fatura_id_foreign` (`fatura_id`),
  ADD KEY `pagamentos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `pagamentos_user_id_foreign` (`user_id`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices para tabela `relatorios`
--
ALTER TABLE `relatorios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Índices para tabela `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Índices para tabela `roteiro_leituristas`
--
ALTER TABLE `roteiro_leituristas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roteiro_leituristas_user_id_foreign` (`user_id`),
  ADD KEY `roteiro_leituristas_fatura_id_foreign` (`fatura_id`),
  ADD KEY `roteiro_leituristas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `roteiro_leituristas_created_by_foreign` (`created_by`);

--
-- Índices para tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices para tabela `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de tabela `backup_configuracaos`
--
ALTER TABLE `backup_configuracaos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `backup_historicos`
--
ALTER TABLE `backup_historicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de tabela `cliente_medidors`
--
ALTER TABLE `cliente_medidors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `configuracao_financeiras`
--
ALTER TABLE `configuracao_financeiras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `configuracoes_app`
--
ALTER TABLE `configuracoes_app`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `documento_historicos`
--
ALTER TABLE `documento_historicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `faturas`
--
ALTER TABLE `faturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `leituras`
--
ALTER TABLE `leituras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `medidores`
--
ALTER TABLE `medidores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `notificacao_configuracaos`
--
ALTER TABLE `notificacao_configuracaos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `relatorios`
--
ALTER TABLE `relatorios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `roteiro_leituristas`
--
ALTER TABLE `roteiro_leituristas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente_medidors`
--
ALTER TABLE `cliente_medidors`
  ADD CONSTRAINT `cliente_medidors_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cliente_medidors_medidor_id_foreign` FOREIGN KEY (`medidor_id`) REFERENCES `medidores` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `configuracoes_app`
--
ALTER TABLE `configuracoes_app`
  ADD CONSTRAINT `configuracoes_app_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `faturas`
--
ALTER TABLE `faturas`
  ADD CONSTRAINT `faturas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `faturas_leitura_id_foreign` FOREIGN KEY (`leitura_id`) REFERENCES `leituras` (`id`);

--
-- Limitadores para a tabela `leituras`
--
ALTER TABLE `leituras`
  ADD CONSTRAINT `leituras_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leituras_editado_por_foreign` FOREIGN KEY (`editado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leituras_medidores_id_foreign` FOREIGN KEY (`medidores_id`) REFERENCES `medidores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leituras_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `pagamentos_fatura_id_foreign` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  ADD CONSTRAINT `pagamentos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `roteiro_leituristas`
--
ALTER TABLE `roteiro_leituristas`
  ADD CONSTRAINT `roteiro_leituristas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roteiro_leituristas_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `roteiro_leituristas_fatura_id_foreign` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `roteiro_leituristas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
