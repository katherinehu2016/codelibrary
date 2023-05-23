create database chccc
	CHARACTER SET utf8;
	
CREATE USER '******'@'localhost' IDENTIFIED BY '********';
GRANT ALL ON chccc.* TO 'chccc'@'localhost';

use chccc;

create table ch_message(
	message_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	message_date date NOT NULL,
	speaker varchar(120) NOT NULL,
	speaker_title varchar(120) NOT NULL,
	message_title varchar(500) NOT NULL,
	speaker_en varchar(120),
	message_title_en varchar(500),
	message_audio_file_name varchar(200),
	message_pdf_file_name varchar(200),
	message_video_file_name varchar(200),
	bible_verses varchar(1000),
	bible_verses_en varchar(1000),
	published bool DEFAULT TRUE,
	PRIMARY KEY(message_id)
);
create index idx_ch_message_date on ch_message(message_date);
create index idx_ch_message_speaker on ch_message(speaker);

create table ch_message_en(
	message_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	message_date date NOT NULL,
	speaker varchar(120) NOT NULL,
	speaker_title varchar(120) NOT NULL,
	message_title varchar(500) NOT NULL,
	speaker_zh varchar(120),
	message_title_zh varchar(500),
	message_audio_file_name varchar(200),
	message_pdf_file_name varchar(200),
	message_video_file_name varchar(200),
	bible_verses varchar(1000),
	bible_verses_en varchar(1000),
	published bool DEFAULT TRUE,
	PRIMARY KEY(message_id)
);
create index idx_ch_message_date on ch_message_en(message_date);
create index idx_ch_message_speaker on ch_message_en(speaker);

create table ch_news(
	news_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	news_date date NOT NULL,
	news_summary varchar(500) NOT NULL,
	news varchar(65535),
	news_summary_en varchar(500),
	news_en varchar(65535),
	sort_order SMALLINT DEFAULT 2,
	published bool DEFAULT TRUE,
	PRIMARY KEY(news_id)
);
create index idx_ch_news_date on ch_news(news_date);

create table ch_music(
	music_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	music_date date NOT NULL,
	music_name varchar(500) NOT NULL,
	music_name_en varchar(500),
	music_audio_file_name varchar(200),
	music_lyrics_file_name varchar(200),
	music_video_file_name varchar(200),
	published bool DEFAULT TRUE,
	PRIMARY KEY(music_id)
);
create index idx_ch_music_date on ch_music(music_date);

create table ch_message_en(
	message_id MEDIUMINT NOT NULL AUTO_INCREMENT,
	message_date date NOT NULL,
	speaker varchar(120) NOT NULL,
	speaker_title varchar(120) NOT NULL,
	message_title varchar(500) NOT NULL,
	speaker_zh varchar(120),
	message_title_zh varchar(500),
	message_audio_file_name varchar(200),
	message_pdf_file_name varchar(200),
	message_video_file_name varchar(200),
	bible_verses varchar(1000),
	bible_verses_zh varchar(1000),
	published bool DEFAULT TRUE,
	PRIMARY KEY(message_id)
);
create index idx_ch_message_date on ch_message_en(message_date);
create index idx_ch_message_speaker on ch_message_en(speaker);
