use kaylios;

create table `notifications` (
    `notify_id` int(11) NOT NULL,
    `notified_by` int(11) not null,
    `type` varchar(255) collate utf8mb4_unicode_ci not null,
    `notify_to` int (11) not null,
    `notify_of` int (11) not null,
    `post_id` int(11) not null,
    `comment_id` int(11) not null,
    `time` datetime not null
    `status` enum('read', 'unread') collate utf8mb4_unicode_ci not null default,
)