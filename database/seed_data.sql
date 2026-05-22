SET FOREIGN_KEY_CHECKS=0;

INSERT INTO `admins` (`id`, `username`, `password_hash`) VALUES
(1, 'rieladmin', '$2y$10$eRjrLygWCFZnkzd.7z7lq.MUvtrYADWMUUnwnxY0NWrdd.qYgbPyu');

INSERT INTO `packages` (`id`, `package_name`, `idr_price`, `us_price`, `orders`) VALUES
(1, 'Starter Plan', 999000, 59.00, 0),
(2, 'Pro Plan', 2499000, 148.00, 3),
(3, 'Premium Plan', 4999000, 295.00, 0),
(4, 'Student Plan', 499000, 29.99, 1),
(5, 'Custom Plan', 500000, 30.00, 0);

INSERT INTO `projects` (`id`, `title`, `slug`, `description`, `image_path`, `url`, `tags`, `stack`, `layout`, `sort_order`, `is_visible`, `created_at`) VALUES
(2, 'PT. Sinergi Sarana Solusi', 'pt-sinergi-sarana-solusi', 'Enterprise digital identity for an Indonesian construction firm. Built a corporate showcase with project portfolio, services catalog, and contact funnel.', 'IMG/projects/3s-tech_1779255932.jpg', 'https://3s-tech.co.id', 'Corporate,Enterprise,System', NULL, 'featured', 1, 1, '2026-05-11 18:07:32'),
(3, 'Parallaxnet Canada', 'parallaxnet-canada', 'Marketing site for Parallaxnet Canada - clean enterprise look with multi-section storytelling.', 'IMG/projects/parallaxnet-ca_1779255951.jpg', 'https://parallaxnet.ca', 'Marketing,Canada,Enterprise', NULL, 'featured', 2, 1, '2026-05-11 18:10:19'),
(4, 'Parallaxnet Siber Indonesia', 'parallaxnet-siber-indonesia', 'An innovative education platform combining technology and business to prepare the next generation for the digital future.', 'IMG/projects/parallaxnet-id_1779255859.jpg', 'https://parallaxnet.id', 'Micro Learning,LMS', NULL, 'side', 1, 1, '2026-05-11 18:11:02'),
(5, 'PT. Dwipa Anugrah Alam Mandiri', 'pt-dwipa-anugrah-alam-mandiri', 'A professional digital solutions company helping businesses strengthen their online presence and digital infrastructure.', 'IMG/projects/daam_1779255915.jpg', 'https://daam.co.id', 'Energy, Waste Management', NULL, 'side', 2, 1, '2026-05-11 18:11:35');

INSERT INTO `testimonials` (`id`, `client_name`, `business_name`, `role_title`, `rating`, `project_url`, `problem_before`, `solution_after`, `recommendation`, `headline`, `client_email`, `consent_given`, `status`, `submitted_at`, `reviewed_at`, `ip_address`, `invite_token`, `token_used`) VALUES
(2, 'Intan Fatma', 'Parallaxnet Siber Indonesia', 'Business Development', 5, 'https://parallaxnet.id/', 'Before working with Rielcode, I needed a website that could present Parallaxnet in a more professional, clear, and attractive way. The main challenge was how to organize the information about our programs, services, and brand identity so visitors could easily understand what Parallaxnet offers.', 'Rielcode helped build a clean, modern, and user-friendly website for Parallaxnet. The website makes the information easier to access, with a neat layout, clear navigation, and content that represents our technology-based education brand well. It helps Parallaxnet look more professional and makes it easier for students, schools, partners, and visitors to learn about our programs.', 'Yes, I would recommend Rielcode to others. Rielcode understands the clients needs and is able to turn ideas into a website that is both functional and visually appealing. The result is professional, easy to use, and suitable for supporting business, education, or organizational branding.', 'Rielcode turned our ideas into a clean, professional, and user-friendly website that truly represents Parallaxnet', NULL, 1, 'approved', '2026-05-12 14:39:43', '2026-05-12 14:54:23', '2404:c0:be02:69ac:b4cd:f0fc:ccdb:1aa5', NULL, 0),
(3, 'Wibowo', 'PT. Sinergi Sarana Solusi', 'Director', 5, 'https://www.3s-tech.co.id', 'Our old website looked outdated and did not reflect the scale of our infrastructure solutions business. Enterprise clients visiting the site questioned our credibility before even contacting us. The layout was cluttered, service pages were unclear, and there was no strong first impression.', 'Rielcode built us a clean, professional company website that clearly presents our three core services: data center infrastructure, renewable energy systems, and energy management platforms. The new site communicates our enterprise positioning immediately. Navigation is straightforward, our product lines are organized, and the design now matches the trust level our clients expect before signing large contracts. Inquiries increased within the first month.', 'Yes. Rielcode understood our technical industry quickly and translated it into a clear, professional online presence without needing constant hand-holding. Fast delivery, clean output, and good communication throughout.', 'Rielcode gave our enterprise infrastructure business the professional website it deserved.', 'info@3s-tech.co.id', 1, 'approved', '2026-05-13 20:48:23', '2026-05-13 20:58:32', '158.140.170.64', NULL, 0),
(4, 'Srigati', 'PT. Dwipa Anugrah Alam Mandiri', 'CEO', 5, 'https://daam.co.id', 'Our website did not represent the complexity or credibility of our engineering work. We handle salt refining systems, water treatment, and industrial infrastructure, but the site looked basic and unprofessional.', 'Rielcode redesigned our company website to properly present our engineering services including salt refining technology, mechanical and electrical systems, water treatment, and renewable energy. The structure is clean, the services are clearly separated, and it now gives the right impression to industrial clients and institutional partners visiting for the first time. Our team no longer has to explain our scope manually before every meeting.', 'Yes. Rielcode handled a niche industrial business well and delivered a site that looks serious without being overbuilt. Good value, efficient process, professional result.', 'Rielcode built us a site that finally matches the scale of our engineering work.', 'info@daam.co.id', 1, 'approved', '2026-05-13 20:57:41', '2026-05-13 20:58:35', '158.140.170.64', NULL, 0);

INSERT INTO `testimonial_invites` (`id`, `token`, `label`, `created_at`, `used_at`, `testimonial_id`) VALUES
(2, 'b8c22b182312b006f08e4944412c1d46a83baf286ac282ce9d4c5abc9aa41f79', 'Parallaxnet Canada', '2026-05-12 01:12:59', NULL, NULL),
(6, '10b3c4b09cf6640995c8b1aee5a9c4e8d4e09ec74741f51f70f806c3a3be069d', 'Parallaxnet Indonesia', '2026-05-12 12:35:46', '2026-05-12 14:39:43', 2),
(7, '659cd8b317ad24c3733f34a2b7aac5947652cbdd33959be20f215a0786556254', NULL, '2026-05-12 12:36:20', '2026-05-12 12:54:02', NULL),
(12, 'ab361f6274c07afefd79b215db24d279e3c218d3881e864d916f9e717452b212', '3s-tech', '2026-05-13 20:47:44', '2026-05-13 20:48:23', 3),
(13, 'cb3fcf34bd61dc6719d4072392816ddfdb46b482c164dc3594195fe101b83bfb', 'PT. DAAM', '2026-05-13 20:48:38', '2026-05-13 20:57:41', 4);

INSERT INTO `orders` (`id`, `order_name`, `email`, `package`, `package_id`, `custom_preset`, `copy_source_url`, `custom_config`, `owns_domain`, `owns_hosting`, `phone_number`, `description`, `status`, `project_stage`, `staging_url`, `invoice_number`, `invoice_file`, `invoice_sent`, `invoice_status`, `invoice_amount`, `invoice_currency`, `invoice_due_date`, `invoice_notes`, `invoice_line_items`, `package_price`, `addons_total`, `final_price`, `created_at`, `payment_method`, `referral_code`) VALUES
(9, 'Wibowo', 'wibowo@daam.co.id', 'Pro Plan', 2, NULL, NULL, NULL, 'Yes', 'Yes', '081284940076', '', 'Completed', 'pending', NULL, 'INV-20251118-9', '../invoices/INV-20251118-9.pdf', 'sent', 'draft', NULL, 'IDR', NULL, NULL, NULL, 0, 0, 0, '2026-03-12 13:27:02', 'Bank Transfer', NULL),
(11, 'azriel', 'afw1407@gmail.com', 'Pro Plan', 2, NULL, NULL, NULL, 'Yes', 'Yes', '081295536876', '', 'Completed', 'pending', NULL, 'INV-20251201-11', '../invoices/INV-20251201-11.pdf', 'sent', 'draft', NULL, 'IDR', NULL, NULL, NULL, 0, 0, 0, '2026-03-12 13:26:59', 'Bank Transfer', NULL),
(28, 'Bryan', 'bryanputra2710@gmail.com', 'Student Plan', 4, NULL, NULL, NULL, 'No', 'No', '085772652294', '', 'On Progress', 'pending', NULL, 'INV-20260313-28', '../invoices/INV-20260313-28.pdf', 'sent', 'draft', NULL, 'IDR', NULL, NULL, NULL, 499000, 0, 499000, '2026-03-13 05:08:18', 'Bank Transfer', NULL),
(31, 'azriel', 'afw1407@gmail.com', 'Pro Plan', 2, NULL, NULL, NULL, 'No', 'No', '081295536876', 'Claimed Year-End Promo: Free Hosting & .COM Domain', 'On Progress', 'pending', NULL, 'INV-20260423-31', '../invoices/INV-20260423-31.pdf', 'sent', 'draft', 1999000.00, 'IDR', '2026-05-20', '', '[{"description":"Pro Plan - base","qty":1,"unit_price":1999000,"total":1999000}]', 1999000, 0, 1999000, '2026-05-12 17:20:37', 'Bank Transfer', NULL);

INSERT INTO `referrers` (`id`, `name`, `phone`, `code`, `commission_rate`, `status`, `created_at`) VALUES
(2, 'Misael Syalom', '085141325027', 'MISAEL67', 10.00, 'active', '2026-05-12 15:04:12'),
(3, 'Aufaanandi', '085198301115', 'NAND24', 10.00, 'active', '2026-05-12 15:04:53'),
(4, 'Fando', '083108362007', 'FRED14', 10.00, 'active', '2026-05-12 15:05:22'),
(5, 'Cynthia', '081278000894', 'CYN10', 10.00, 'active', '2026-05-12 15:16:23'),
(6, 'Yeza', '081521555828', 'YEZ10', 10.00, 'active', '2026-05-12 15:19:29');

INSERT INTO `rate_limits` (`id`, `ip_address`, `bucket`, `window_start`, `counter`, `updated_at`) VALUES
(1, '158.140.170.95', 'hour', '2026-05-20 12:00:00', 1, '2026-05-20 05:38:53'),
(2, '158.140.170.95', 'day', '2026-05-20 00:00:00', 1, '2026-05-20 05:38:53'),
(3, '158.140.170.95', 'tokens_day', '2026-05-20 00:00:00', 1753, '2026-05-20 05:38:57');

INSERT INTO `audit_log` (`id`, `event_code`, `severity`, `actor`, `ip_address`, `ref_table`, `ref_id`, `message`, `meta`, `created_at`) VALUES
(1, 'ADMIN_LOGIN_OK', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, NULL, '2026-05-20 12:39:24'),
(2, 'ADMIN_CRUD', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, '{"table":"projects","action":"update","id":4}', '2026-05-20 12:44:20'),
(3, 'ADMIN_CRUD', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, '{"table":"projects","action":"update","id":5}', '2026-05-20 12:44:33'),
(4, 'ADMIN_CRUD', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, '{"table":"projects","action":"update","id":5}', '2026-05-20 12:45:15'),
(5, 'ADMIN_CRUD', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, '{"table":"projects","action":"update","id":2}', '2026-05-20 12:45:32'),
(6, 'ADMIN_CRUD', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, '{"table":"projects","action":"update","id":3}', '2026-05-20 12:45:51'),
(7, 'ADMIN_LOGIN_OK', 'info', 'rieladmin', '158.140.170.95', NULL, NULL, NULL, NULL, '2026-05-22 09:52:26');

SET FOREIGN_KEY_CHECKS=1;
