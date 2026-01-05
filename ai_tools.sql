-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 03:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai_tools`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_tools`
--

CREATE TABLE `ai_tools` (
  `tool_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `subscription` varchar(50) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL,
  `clean_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_tools`
--

INSERT INTO `ai_tools` (`tool_id`, `company_name`, `votes`, `subscription`, `category`, `clean_text`) VALUES
(1, 'Humata AI', 2955, 'Freemium', 'human resources legal ai chatbots', 'humata ai human resources legal ai chatbots freemium\r'),
(2, 'Shuffll', 804, 'Paid', 'marketing education video generators', 'shuffll marketing education video generators paid\r'),
(3, 'Textero AI Essay Writer', 234, 'Freemium', 'writing generators education storyteller', 'textero ai essay writer writing generators education storyteller freemium\r'),
(4, 'ChatGPT', 5151, 'Freemium', 'writing generators education ai chatbots', 'chatgpt writing generators education ai chatbots freemium\r'),
(5, 'Tome', 4162, 'Free', 'storyteller presentations startup tools', 'tome storyteller presentations startup tools free\r'),
(6, 'Midjourney', 3265, 'Free Trial', 'design generators image generators text to image', 'midjourney design generators image generators text to image free trial\r'),
(7, 'Durable', 2831, 'Freemium', 'website builders low code no code startup tools', 'durable website builders low code no code startup tools freemium\r'),
(8, 'Namelix', 4645, 'Free', 'marketing logo generator startup tools', 'namelix marketing logo generator startup tools free\r'),
(9, 'Fliki', 4150, '', 'audio editing text to speech video generators', 'fliki audio editing text to speech video generators\r'),
(10, 'Codeium', 3217, 'Free', 'code assistant ai chatbots', 'codeium code assistant ai chatbots free\r'),
(11, 'Riffusion', 3110, 'Free', 'audio editing music fun tools', 'riffusion audio editing music fun tools free\r'),
(12, 'Piggy', 2979, 'Free', 'marketing social media', 'piggy marketing social media free\r'),
(13, 'NightCafe Studio', 1805, 'Freemium', 'design generators image generators', 'nightcafe studio design generators image generators freemium\r'),
(14, 'TutorAI', 1797, 'Freemium', 'education students research', 'tutorai education students research freemium\r'),
(15, 'Boomy', 1792, 'Freemium', 'music', 'boomy music freemium\r'),
(16, 'ChatGPT Writer', 1761, 'Free', 'email assistant', 'chatgpt writer email assistant free\r'),
(17, 'Jasper', 1694, 'Free Trial', 'writing generators paraphrasing copywriting', 'jasper writing generators paraphrasing copywriting free trial\r'),
(18, 'DALL-E 2', 1674, 'Freemium', 'image generators', 'dall e 2 image generators freemium\r'),
(19, 'MidJourney Prompt Helper', 1706, 'Free', 'prompt generators design generators image generators', 'midjourney prompt helper prompt generators design generators image generators free\r'),
(20, 'Stable Diffusion', 1702, 'Freemium', 'design generators image generators text to image', 'stable diffusion design generators image generators text to image freemium\r'),
(21, 'Mubert', 1713, 'Freemium', 'audio editing music', 'mubert audio editing music freemium\r'),
(22, 'Validator AI', 1584, 'Free', 'startup tools', 'validator ai startup tools free\r'),
(23, 'Magic Studio', 1588, 'Freemium', 'image generators image editing', 'magic studio image generators image editing freemium\r'),
(24, 'Autodraw', 1602, 'Free', 'design generators', 'autodraw design generators free\r'),
(25, 'Notion AI', 1558, 'Freemium', 'writing generators project management', 'notion ai writing generators project management freemium\r'),
(26, 'MarketingBlocks', 1496, 'Freemium', 'website builders marketing video generators', 'marketingblocks website builders marketing video generators freemium\r'),
(27, 'IdeasAI', 1546, 'Free', 'startup tools fun tools', 'ideasai startup tools fun tools free\r'),
(28, 'Craiyon', 1531, 'Free', 'cartoon generators image generators text to image', 'craiyon cartoon generators image generators text to image free\r'),
(29, 'Munch', 1528, '', 'marketing social media video editing', 'munch marketing social media video editing\r'),
(30, 'Fy! Studio', 1516, 'Free', 'design generators image generators', 'fy studio design generators image generators free\r'),
(31, 'Wisdolia', 1451, 'Free', 'education students summarizer', 'wisdolia education students summarizer free\r'),
(32, 'PowerMode AI', 1415, 'Free', 'marketing presentations startup tools', 'powermode ai marketing presentations startup tools free\r'),
(33, 'PaperBrain', 1435, 'Free', 'education students research', 'paperbrain education students research free\r'),
(34, 'Synthesia', 1451, 'Paid', 'avatars video generators text to video', 'synthesia avatars video generators text to video paid\r'),
(35, 'Pollinations', 1398, 'Free', 'design generators image generators', 'pollinations design generators image generators free\r'),
(36, 'Rytr', 1363, 'Freemium', 'paraphrasing storyteller copywriting', 'rytr paraphrasing storyteller copywriting freemium\r'),
(37, 'Public Prompts', 1376, 'Free', 'prompt generators', 'public prompts prompt generators free\r'),
(38, 'Where To', 1327, 'Free', 'travel', 'where to travel free\r'),
(39, 'Profile Picture AI', 1349, 'Paid', 'portrait generators image generators avatars', 'profile picture ai portrait generators image generators avatars paid\r'),
(40, 'Scribble Diffusion', 1341, 'Free', 'design generators image editing', 'scribble diffusion design generators image editing free\r'),
(41, 'MarsX', 1321, 'Free', 'website builders code assistant low code no code', 'marsx website builders code assistant low code no code free\r'),
(42, 'IngestAI', 1094, 'Freemium', 'workflows project management low code no code', 'ingestai workflows project management low code no code freemium\r'),
(43, 'Stockimg.ai', 1129, 'Free Trial', 'design generators image generators', 'stockimg ai design generators image generators free trial\r'),
(44, 'Glambase', 1103, '', 'social media avatars', 'glambase social media avatars\r'),
(45, 'Uberduck', 1261, 'Free', 'audio editing text to speech music', 'uberduck audio editing text to speech music free\r'),
(46, 'Safurai', 1255, 'Free', 'code assistant low code no code', 'safurai code assistant low code no code free\r'),
(47, 'AirOps', 1217, 'Freemium', 'project management ai chatbots', 'airops project management ai chatbots freemium\r'),
(48, 'Adobr Podcast', 1212, 'Free', 'social media education audio editing', 'adobr podcast social media education audio editing free\r'),
(49, 'Monica', 1109, 'Freemium', 'personal assistant translator ai chatbots', 'monica personal assistant translator ai chatbots freemium\r'),
(50, 'ThumbnailAi', 1179, 'Free', 'design generators social media', 'thumbnailai design generators social media free\r'),
(51, 'Merlin', 1176, 'Free', 'ai chatbots summarizer email assistant', 'merlin ai chatbots summarizer email assistant free\r'),
(52, 'timeOS', 869, 'Freemium', 'summarizer', 'timeos summarizer freemium\r'),
(53, 'Bright Eyw', 1024, 'Free', 'image generators social media gaming', 'bright eyw image generators social media gaming free\r'),
(54, 'WatchNow AI', 1106, 'Free', 'personal assistant fun tools', 'watchnow ai personal assistant fun tools free\r'),
(55, 'Quillbot', 1104, 'Freemium', 'writing generators paraphrasing summarizer', 'quillbot writing generators paraphrasing summarizer freemium\r'),
(56, 'MagicForm', 956, 'Freemium', 'low code no code sales', 'magicform low code no code sales freemium\r'),
(57, 'Socratic by Google', 1100, 'Free', 'education personal assistant research', 'socratic by google education personal assistant research free\r'),
(58, 'Magic Type AI', 1097, 'Free', 'writing generators copywriting email assistant', 'magic type ai writing generators copywriting email assistant free\r'),
(59, 'Creative Reality Studio', 1073, 'Free Trial', 'text to speech video generators text to video', 'creative reality studio text to speech video generators text to video free trial\r'),
(60, 'SheetAI.app', 1070, '', 'spreadsheets', 'sheetai app spreadsheets\r'),
(61, 'SEO GPT', 1067, 'Free', 'marketing seo', 'seo gpt marketing seo free\r'),
(63, 'Imagecolorizer', 1057, 'Free', 'image editing fun tools', 'imagecolorizer image editing fun tools free\r'),
(64, 'Lucidpic', 966, 'Freemium', 'image generators social media avatars', 'lucidpic image generators social media avatars freemium\r'),
(65, 'Namy.ai', 1007, 'Free', 'logo generator startup tools', 'namy ai logo generator startup tools free\r'),
(66, 'Casper AI', 977, 'Free', 'research summarizer', 'casper ai research summarizer free\r'),
(67, 'Pixelicious', 995, 'Free', 'image editing', 'pixelicious image editing free\r'),
(68, 'Kinetix', 993, 'Paid', 'video generators 3d gaming', 'kinetix video generators 3d gaming paid\r'),
(69, 'ProductBot', 965, 'Free', 'e commerce customer support ai chatbots', 'productbot e commerce customer support ai chatbots free\r'),
(70, 'Civitai', 983, 'Free', 'education', 'civitai education free\r'),
(71, 'Predict AI', 953, 'Paid', 'design generators social media', 'predict ai design generators social media paid\r'),
(72, 'Glasp', 972, 'Free', 'social media copywriting', 'glasp social media copywriting free\r'),
(73, 'WolframAlpha', 920, 'Freemium', 'education students', 'wolframalpha education students freemium\r'),
(74, 'HoppyCopy', 917, 'Free Trial', 'marketing copywriting email assistant', 'hoppycopy marketing copywriting email assistant free trial\r'),
(75, 'Microsoft Bing', 932, 'Free', 'personal assistant research search engine', 'microsoft bing personal assistant research search engine free\r'),
(76, 'STORYD', 833, 'Freemium', 'storyteller presentations copywriting', 'storyd storyteller presentations copywriting freemium\r'),
(77, 'Teachable Machine', 889, 'Free', 'education low code no code ai detection', 'teachable machine education low code no code ai detection free\r'),
(78, 'Pixela AI', 884, 'Free', 'design generators image editing 3d', 'pixela ai design generators image editing 3d free\r'),
(79, 'Descript', 884, 'Freemium', 'audio editing video editing transcriber', 'descript audio editing video editing transcriber freemium\r'),
(80, 'Woebot Health', 872, 'Free', 'health ai chatbots', 'woebot health health ai chatbots free\r'),
(81, 'Moonbeam', 847, 'Free Trial', 'marketing writing generators', 'moonbeam marketing writing generators free trial\r'),
(82, 'Excel Formula Bot', 855, 'Freemium', 'spreadsheets sql', 'excel formula bot spreadsheets sql freemium\r'),
(83, 'Gamma', 512, 'Free Trial', 'presentations copywriting startup tools', 'gamma presentations copywriting startup tools free trial\r'),
(84, 'Interior AI', 831, 'Free Trial', 'image editing 3d real estate', 'interior ai image editing 3d real estate free trial\r'),
(85, 'TubeMagic', 795, 'Paid', 'social media seo video generators', 'tubemagic social media seo video generators paid\r'),
(86, 'Booom', 810, 'Free', 'fun tools gaming', 'booom fun tools gaming free\r'),
(87, 'Palette.fm', 826, 'Freemium', 'image generators education image editing', 'palette fm image generators education image editing freemium\r'),
(88, 'ChefGPT', 825, 'Freemium', 'fitness health fun tools', 'chefgpt fitness health fun tools freemium\r'),
(89, 'Roamaround', 779, 'Free', 'project management research', 'roamaround project management research free\r'),
(90, 'Klap', 647, 'Free Trial', 'video generators', 'klap video generators free trial\r'),
(91, 'Genmo AI', 767, 'Free', 'video generators text to video', 'genmo ai video generators text to video free\r'),
(92, 'Perplexity', 766, 'Freemium', 'writing generators ai chatbots search engine', 'perplexity writing generators ai chatbots search engine freemium\r'),
(93, 'Podcast', 785, 'Free', 'education storyteller text to speech', 'podcast education storyteller text to speech free\r'),
(94, 'HarmonAI', 805, 'Free', 'music', 'harmonai music free\r'),
(95, 'GET3D by NVIDIA', 743, 'Free', '3d gaming', 'get3d by nvidia 3d gaming free\r'),
(96, 'PlayArti', 767, 'Free', 'design generators image editing', 'playarti design generators image editing free\r'),
(97, 'Easy Peasy AI', 670, '', 'text to speech copywriting transcriber', 'easy peasy ai text to speech copywriting transcriber\r'),
(98, 'MeetGeek', 749, 'Free', 'personal assistant summarizer transcriber', 'meetgeek personal assistant summarizer transcriber free\r'),
(99, 'AI Studios', 741, 'Paid', 'education video generators text to video', 'ai studios education video generators text to video paid\r'),
(100, 'Canva Text to Image', 735, 'Freemium', 'design generators marketing text to image', 'canva text to image design generators marketing text to image freemium\r'),
(101, 'Runwayml', 711, 'Freemium', 'image generators storyteller video generators', 'runwayml image generators storyteller video generators freemium\r'),
(102, 'AutoGPT', 679, 'Free', 'ai agents', 'autogpt ai agents free\r'),
(103, 'TwitterBio', 715, 'Free', 'writing generators social media ai chatbots', 'twitterbio writing generators social media ai chatbots free\r'),
(104, 'Phind', 666, 'Free', 'education search engine', 'phind education search engine free\r'),
(105, 'Chromox', 604, 'Free', 'prompt generators video generators', 'chromox prompt generators video generators free\r'),
(106, 'Upword', 683, 'Free Trial', 'education research summarizer', 'upword education research summarizer free trial\r'),
(107, 'Replit', 698, 'Freemium', 'education code assistant low code no code', 'replit education code assistant low code no code freemium\r'),
(108, 'Audyo', 655, 'Free Trial', 'audio editing text to speech transcriber', 'audyo audio editing text to speech transcriber free trial\r'),
(109, 'Ordinary People Prompts', 692, 'Free', 'prompt generators education ai chatbots', 'ordinary people prompts prompt generators education ai chatbots free\r'),
(110, 'Gen-2 by Runway', 609, 'Free Trial', 'design generators image generators video generators', 'gen 2 by runway design generators image generators video generators free trial\r'),
(111, 'Facial Assessment Tool', 669, 'Free', 'health ai detection', 'facial assessment tool health ai detection free\r'),
(112, 'Papercup', 681, 'Paid', 'video editing translator', 'papercup video editing translator paid\r'),
(113, 'Suggest Gift', 678, 'Free', 'personal assistant gift ideas', 'suggest gift personal assistant gift ideas free\r'),
(114, 'Build AI', 677, 'Paid', 'marketing low code no code', 'build ai marketing low code no code paid\r'),
(115, 'GitFluence', 656, 'Free', 'code assistant low code no code', 'gitfluence code assistant low code no code free\r'),
(116, 'Consensus', 636, 'Freemium', 'education research search engine', 'consensus education research search engine freemium\r'),
(117, 'Taskade', 655, 'Freemium', 'workflows project management ai chatbots', 'taskade workflows project management ai chatbots freemium\r'),
(118, 'Softr Studio', 675, 'Freemium Free Trial', 'website builders low code no code startup tools', 'softr studio website builders low code no code startup tools freemium free trial\r'),
(119, 'Arcwise', 652, 'Paid', 'spreadsheets sql startup tools', 'arcwise spreadsheets sql startup tools paid\r'),
(120, 'ImageCreator', 571, 'Free', 'image generators image editing', 'imagecreator image generators image editing free\r'),
(121, 'Mixo', 610, 'Free Trial', 'website builders low code no code startup tools', 'mixo website builders low code no code startup tools free trial\r'),
(122, 'Fast.ai', 668, 'Free', 'education', 'fast ai education free\r'),
(123, 'Maps GPT', 666, 'Free', 'travel fun tools', 'maps gpt travel fun tools free\r'),
(124, 'Flair AI', 656, 'Free Trial', 'design generators image generators e commerce', 'flair ai design generators image generators e commerce free trial\r'),
(125, 'LongShot', 653, 'Freemium', 'writing generators seo', 'longshot writing generators seo freemium\r'),
(126, 'JourneAI', 652, 'Free', 'travel', 'journeai travel free\r'),
(127, 'Zapt', 582, 'Freemium', 'low code no code startup tools', 'zapt low code no code startup tools freemium\r'),
(128, 'AI Trip Planner', 619, 'Freemium', 'travel', 'ai trip planner travel freemium\r'),
(129, 'Chatbase', 536, 'Paid', 'marketing customer support ai chatbots', 'chatbase marketing customer support ai chatbots paid\r'),
(130, 'ELI5', 626, 'Freemium', 'education students fun tools', 'eli5 education students fun tools freemium\r'),
(131, 'Google Gemini', 577, 'Freemium', 'writing generators code assistant ai chatbots', 'google gemini writing generators code assistant ai chatbots freemium\r'),
(132, 'Aidaptive', 577, 'Free Trial', 'marketing e commerce research', 'aidaptive marketing e commerce research free trial\r'),
(133, 'AI Transcription by Riverside', 436, 'Free', 'transcriber', 'ai transcription by riverside transcriber free\r'),
(134, 'Vocal Remover', 575, 'Free', 'audio editing music', 'vocal remover audio editing music free\r'),
(135, 'Find Your Next Book', 602, 'Free', 'personal assistant fun tools', 'find your next book personal assistant fun tools free\r'),
(136, 'AgentGPT', 578, 'Free', 'personal assistant seo research', 'agentgpt personal assistant seo research free\r'),
(137, 'Drayk It', 591, 'Free', 'music fun tools', 'drayk it music fun tools free\r'),
(138, 'Microsoft Designer', 584, 'Paid', 'design generators image editing presentations', 'microsoft designer design generators image editing presentations paid\r'),
(139, 'Taplio', 559, 'Free Trial', 'marketing social media sales', 'taplio marketing social media sales free trial\r'),
(140, 'Yaara', 576, '', 'social media seo copywriting', 'yaara social media seo copywriting\r'),
(141, 'DoNotPay', 566, 'Paid', 'finance legal', 'donotpay finance legal paid\r'),
(142, 'Natural Language Playlist', 544, 'Free', 'music search engine fun tools', 'natural language playlist music search engine fun tools free\r'),
(143, 'Peppertype.ai', 563, 'Freemium', 'marketing seo copywriting', 'peppertype ai marketing seo copywriting freemium\r'),
(144, 'Laion', 540, 'Free', 'research', 'laion research free\r'),
(145, 'Quizgecko', 479, 'Freemium', 'education students teachers', 'quizgecko education students teachers freemium\r'),
(146, 'Amazon CodeWhisperer', 557, 'Free', 'education code assistant', 'amazon codewhisperer education code assistant free\r'),
(147, 'Copymatic', 536, 'Free Trial', 'writing generators social media copywriting', 'copymatic writing generators social media copywriting free trial\r'),
(148, 'StudioGPT by Latent Labs', 553, 'Paid', 'design generators image editing', 'studiogpt by latent labs design generators image editing paid\r'),
(149, 'GitaGPT', 520, 'Free', 'religion', 'gitagpt religion free\r'),
(150, 'Cohesive', 438, 'Free Trial', 'marketing copywriting', 'cohesive marketing copywriting free trial\r'),
(151, 'GPT-3 Playground', 516, 'Free Trial', 'writing generators education code assistant', 'gpt 3 playground writing generators education code assistant free trial\r'),
(152, 'PPLEGPT', 535, 'Free', 'fitness health', 'pplegpt fitness health free\r'),
(153, 'Never', 353, 'Freemium', 'portrait generators image generators avatars', 'never portrait generators image generators avatars freemium\r'),
(154, 'Hypotenuse', 491, 'Free Trial', 'seo copywriting summarizer', 'hypotenuse seo copywriting summarizer free trial\r'),
(155, 'GitHub Copilot', 496, 'Free Trial', 'code assistant low code no code', 'github copilot code assistant low code no code free trial\r'),
(156, 'Superflows', 408, 'Freemium', 'ai chatbots startup tools', 'superflows ai chatbots startup tools freemium\r'),
(157, 'GetFloorPlan', 461, 'Freemium', 'design generators 3d real estate', 'getfloorplan design generators 3d real estate freemium\r'),
(158, 'Syllaby', 358, 'Freemium', 'social media', 'syllaby social media freemium\r'),
(159, 'Cleanup.pictures', 498, 'Freemium', 'e commerce image editing real estate', 'cleanup pictures e commerce image editing real estate freemium\r'),
(160, 'MovieToEmoji', 456, 'Free', 'social media education fun tools', 'movietoemoji social media education fun tools free\r'),
(161, 'Summarize Tech', 494, 'Free', 'education summarizer', 'summarize tech education summarizer free\r'),
(162, 'AI Experiments', 488, 'Free', 'education', 'ai experiments education free\r'),
(163, 'Lunaa', 461, 'Free Trial', 'marketing social media', 'lunaa marketing social media free trial\r'),
(164, 'EbSynth', 460, 'Free', 'education video generators', 'ebsynth education video generators free\r'),
(165, 'Creative AI', 408, '', 'marketing social media copywriting', 'creative ai marketing social media copywriting\r'),
(166, 'Speechify', 448, 'Freemium', 'text to speech', 'speechify text to speech freemium\r'),
(167, 'Krisp', 465, 'Freemium', 'audio editing customer support', 'krisp audio editing customer support freemium\r'),
(256, 'Claude AI', 6540, 'Freemium', 'Chatbot', 'ai assistant focused on safety long context and reasoning'),
(258, 'Microsoft Copilot', 1701, 'Freemium', 'Productivity', 'ai assistant integrated with microsoft office and windows');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tool_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `user_id`, `tool_id`, `rating`, `created_at`) VALUES
(3, 2, 4, 5, '2026-01-05 00:05:00'),
(4, 3, 4, 5, '2026-01-05 00:23:12'),
(5, 3, 71, 5, '2026-01-05 00:24:25'),
(6, 4, 11, 5, '2026-01-05 00:30:50'),
(7, 4, 4, 5, '2026-01-05 00:39:51'),
(9, 1, 12, 5, '2026-01-05 00:41:51'),
(10, 1, 50, 5, '2026-01-05 00:42:32'),
(11, 4, 52, 5, '2026-01-05 00:43:33'),
(12, 1, 8, 5, '2026-01-05 01:52:22'),
(13, 1, 1, 5, '2026-01-05 01:52:32'),
(14, 1, 4, 5, '2026-01-05 01:52:44'),
(15, 5, 131, 5, '2026-01-05 01:58:01'),
(16, 5, 58, 4, '2026-01-05 01:58:24'),
(17, 5, 4, 5, '2026-01-05 01:58:37'),
(18, 5, 92, 5, '2026-01-05 01:58:56'),
(19, 5, 39, 4, '2026-01-05 01:59:34'),
(20, 5, 162, 4, '2026-01-05 02:00:01'),
(21, 6, 55, 4, '2026-01-05 02:09:35'),
(22, 6, 71, 5, '2026-01-05 02:09:52'),
(23, 6, 99, 4, '2026-01-05 02:13:57'),
(24, 6, 19, 5, '2026-01-05 02:17:44'),
(25, 6, 3, 4, '2026-01-05 02:18:04'),
(26, 6, 34, 4, '2026-01-05 02:33:11'),
(27, 1, 155, 5, '2026-01-05 16:41:57'),
(28, 1, 5, 5, '2026-01-05 16:42:10'),
(29, 7, 48, 4, '2026-01-05 16:54:38'),
(30, 7, 78, 5, '2026-01-05 16:55:05'),
(31, 7, 24, 3, '2026-01-05 16:55:30'),
(32, 7, 120, 4, '2026-01-05 16:55:50'),
(33, 7, 8, 2, '2026-01-05 16:55:57'),
(34, 7, 16, 3, '2026-01-05 16:56:12'),
(35, 7, 165, 3, '2026-01-05 16:56:48'),
(36, 7, 10, 3, '2026-01-05 16:56:56'),
(37, 7, 1, 2, '2026-01-05 16:57:16'),
(38, 7, 12, 2, '2026-01-05 16:57:28'),
(39, 4, 44, 4, '2026-01-05 18:43:50'),
(40, 4, 77, 3, '2026-01-05 18:44:11'),
(41, 4, 75, 4, '2026-01-05 18:44:23'),
(42, 4, 167, 4, '2026-01-05 18:44:43'),
(43, 4, 151, 4, '2026-01-05 18:45:29'),
(44, 4, 153, 5, '2026-01-05 18:45:47'),
(45, 4, 256, 5, '2026-01-05 21:59:17'),
(46, 4, 258, 3, '2026-01-05 21:59:26'),
(47, 8, 25, 4, '2026-01-05 22:06:59'),
(48, 8, 72, 4, '2026-01-05 22:08:11'),
(49, 8, 12, 1, '2026-01-05 22:08:24'),
(50, 8, 163, 4, '2026-01-05 22:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Delphi', 'delphi@gmail.com', '$2y$10$bEHX3Yh63Mqp2YpTUJI3OejohKgf35h7O.dciCV2ZZXf.nyn91So.', '2026-01-04 22:28:05'),
(2, 'Rashad', 'rashad@gmail.com', '$2y$10$/pnTKCdVFFB8UUVBLV17puNGzPoVvDFEJlg.Wg6BGVOG3jIXijJTW', '2026-01-05 00:04:00'),
(3, 'jeno', 'jeno@gmail.com', '$2y$10$37K5cjeXztcOuZMPjlUXHevuZCAEhENB1AE22dwlxM1aaVhuegpUi', '2026-01-05 00:22:28'),
(4, 'delphi', 'iphled@gmail.com', '$2y$10$hMA.QJvoSDOaK1Z04Symb.daP3lMKp10Q66NIRaTdY52EcS0Yd.vy', '2026-01-05 00:29:30'),
(5, 'Karina', 'karina@gmail.com', '$2y$10$mkjFf1zhTI1gyMN7mApE1OYhqX7ZILjqkufnOHzvpCOaOf6HfvCEK', '2026-01-05 01:57:15'),
(6, 'rizki', 'plenger@gmail.com', '$2y$10$/HPghfZALRiFpxnd5hIX.OV8hKUdBgUWqJoriGCHz2agM4s2wYpUK', '2026-01-05 02:08:45'),
(7, 'jake sully', 'jake@gmail.com', '$2y$10$U4.xkB5b3R39eRBO1kvoyeo/54GG5h4rEVgWJhin9uSmRUBSwkaNW', '2026-01-05 16:53:44'),
(8, 'ningning', 'ningning@gmail.com', '$2y$10$/ERm6Tb5i2GWc9LqPkDwRuH.ofz3n/q1dqmKNKz0KIliCi2I1u5mC', '2026-01-05 22:06:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_tools`
--
ALTER TABLE `ai_tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`tool_id`),
  ADD KEY `tool_id` (`tool_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_tools`
--
ALTER TABLE `ai_tools`
  MODIFY `tool_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `ai_tools` (`tool_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
