USE [aerjs]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[syllabus_head](
	[id_syllabus] [int] IDENTITY(1,1) NOT NULL,
	[confirmation] [bit] NULL,
	[id_speciality] [int] NULL,
	[id_discipline] [int] NULL,
	[id_teacher] [int] NULL,
	[id_year] [int] NULL,
	[assistant] [varchar](50) NULL,
	[code] [nvarchar](10) NULL,
	[id_semester] [int] NULL,
	[hour_week] [int] NULL,
	[lecture] [int] NULL,
	[laboratory] [int] NULL,
	[practice] [int] NULL,
	[seminar] [int] NULL,
	[kredit_ECTS] [int] NULL,
	[course_raiting] [varchar](50) NULL,
	[course_type] [varchar](50) NULL,
	[course_language] [varchar](50) NULL,
	[purpose] [varchar](500) NULL,
	[annotation] [varchar](1500) NULL,
	[competence] [varchar](500) NULL,
	[result_learning] [varchar](500) NULL,
	[student_know] [varchar](1500) NULL,
	[student_must] [varchar](1500) NULL,
	[id_update] [date] NULL,
	[id_sillabus_t] [bigint] NULL,
	[StudyTypeID] [int] NULL,
	[instrumentos] [varchar](500) NULL,
	[id_educ_sh] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id_syllabus] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[syllabus_rating](
	[id_rating] [int] IDENTITY(1,1) NOT NULL,
	[id_student] [int] NULL,
	[id_group] [int] NULL,
	[id_sillabus_t] [bigint] NULL,
	[date_rating] [datetime] NULL,
	[status_rating] [varchar](50) NULL,
	[id_rate] [int] NULL,
	[id_schedule] [int] NULL,
	[id_subject] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id_rating] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[syllabus_subject](
	[id_subject] [int] IDENTITY(1,1) NOT NULL,
	[id_syllabus] [int] NULL,
	[subject_type] [int] NOT NULL,
	[subject_hour] [int] NOT NULL,
	[subject_past_hour] [int] NOT NULL,
	[subject_name] [varchar](1000) NOT NULL,
	[id_sillabus_t] [bigint] NULL,
	[subject_num] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id_subject] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[syllabus_subject_hour](
	[id_subject_hour] [int] IDENTITY(1,1) NOT NULL,
	[id_sillabus_t] [bigint] NULL,
	[subject_past_hour] [int] NULL,
	[subject_type] [int] NULL,
	[subject_past_hour_date] [datetime] NULL,
	[id_syllabus_subject] [int] NULL,
	[subject_num] [int] NULL,
	[id_group] [int] NULL,
	[id_schedule] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id_subject_hour] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[syllabus_textbook](
	[id_textbook] [int] IDENTITY(1,1) NOT NULL,
	[id_syllabus] [int] NULL,
	[textbook_autor] [varchar](255) NULL,
	[textbook_name] [varchar](255) NULL,
	[textbook_link] [varchar](255) NULL,
	[id_sillabus_t] [bigint] NULL,
	[textbook_num] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id_textbook] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[syllabus_head] ADD  CONSTRAINT [DF__syllabus___confi__59063A47]  DEFAULT ((0)) FOR [confirmation]
GO
ALTER TABLE [dbo].[syllabus_subject] ADD  DEFAULT ((0)) FOR [subject_past_hour]
GO
