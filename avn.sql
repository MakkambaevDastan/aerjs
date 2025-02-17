USE [avn]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[a_year](
	[id_a_year] [float] NULL,
	[p32] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[sh_year] [float] NULL,
	[u_god] [float] NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AVN_User](
	[id_AVN_user] [float] NULL,
	[AVN_login] [nvarchar](255) NULL,
	[AVN_password] [nvarchar](255) NULL,
	[name] [nvarchar](255) NULL,
	[surname] [nvarchar](255) NULL,
	[patronymic] [nvarchar](255) NULL,
	[doljnost] [nvarchar](255) NULL,
	[activ] [float] NULL,
	[kol_p] [float] NULL,
	[start_dp] [datetime] NULL,
	[end_dp] [datetime] NULL,
	[Old_password] [nvarchar](255) NULL,
	[visible] [float] NULL,
	[type] [float] NULL,
	[b] [float] NULL,
	[k] [float] NULL,
	[id_kassa] [nvarchar](255) NULL,
	[passLife] [float] NULL,
	[id_language] [float] NULL,
	[temp] [float] NULL,
	[canUploadUmk] [float] NULL,
	[AVN37_import] [float] NULL,
	[Attribute] [nvarchar](255) NULL,
	[op] [nvarchar](255) NULL,
	[canChangeDopusk] [float] NULL,
	[canEditAVN38] [float] NULL,
	[canEditAVN2] [float] NULL,
	[canTerminal] [nvarchar](255) NULL,
	[isSmsAdmin] [float] NULL,
	[canRemoveDFSFromExStudent] [float] NULL,
	[canShtat_rasp_otdel] [float] NULL,
	[canShtat_rasp_faculty] [float] NULL,
	[F33] [nvarchar](255) NULL,
	[F34] [nvarchar](255) NULL,
	[F35] [nvarchar](255) NULL,
	[F36] [nvarchar](255) NULL,
	[F37] [nvarchar](255) NULL
) ON [PRIMARY]
GO=
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AVNTeacher](
	[id_avn_teacher] [float] NULL,
	[id_avn_login] [float] NULL,
	[id_teacher] [float] NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[direction](
	[id_direction] [int] NOT NULL,
	[p24-1] [varchar](255) NOT NULL,
	[p24-2] [varchar](255) NOT NULL,
	[id_faculty] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id_direction] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[discipline](
	[id_discipline] [float] NULL,
	[p34] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[code_discipline] [nvarchar](255) NULL,
	[rasp_code_discipline] [nvarchar](255) NULL,
	[s_p34] [nvarchar](255) NULL,
	[p34_eng] [nvarchar](255) NULL,
	[p34_kg] [nvarchar](255) NULL,
	[plan_nag] [nvarchar](255) NULL,
	[F11] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[educ_sh](
	[id_educ_sh] [float] NULL,
	[id_speciality] [float] NULL,
	[id_a_year] [float] NULL,
	[id_semester] [float] NULL,
	[id_component] [nvarchar](255) NULL,
	[id_kind] [float] NULL,
	[id_teacher] [float] NULL,
	[id_kafedra] [float] NULL,
	[id_discipline] [float] NULL,
	[id_control] [float] NULL,
	[id_examination] [float] NULL,
	[p51] [float] NULL,
	[p52] [float] NULL,
	[p53] [float] NULL,
	[srs] [float] NULL,
	[rzr] [float] NULL,
	[ind_z] [nvarchar](255) NULL,
	[seminar] [float] NULL,
	[p54] [float] NULL,
	[oper] [nvarchar](255) NULL,
	[u_date] [datetime] NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[Krdt] [float] NULL,
	[descGroupNum] [float] NULL,
	[isSelect] [float] NULL,
	[id_disciplineName] [nvarchar](255) NULL,
	[colnedel] [nvarchar](255) NULL,
	[interactive] [nvarchar](255) NULL,
	[srsp] [nvarchar](255) NULL,
	[code_discipline] [float] NULL,
	[vid_discipline] [nvarchar](255) NULL,
	[koefZD] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[examinator](
	[id_examinator] [int] IDENTITY(1,1) NOT NULL,
	[id_teacher] [int] NOT NULL,
	[id_discipline] [int] NOT NULL,
	[id_a_year] [int] NOT NULL,
	[id_semester] [int] NOT NULL,
	[id_group] [int] NOT NULL,
	[id_examination] [int] NOT NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[faculty](
	[id_faculty] [float] NULL,
	[p23-1] [nvarchar](255) NULL,
	[p23-2] [nvarchar](255) NULL,
	[id_vuz] [float] NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[priem_abit] [nvarchar](255) NULL,
	[p23-2_k] [nvarchar](255) NULL,
	[sort] [nvarchar](255) NULL,
	[id_ua] [float] NULL,
	[__code] [nvarchar](255) NULL,
	[p23-3] [nvarchar](255) NULL,
	[p23-4] [nvarchar](255) NULL,
	[n_director] [nvarchar](255) NULL,
	[stukture] [nvarchar](255) NULL,
	[f_group] [nvarchar](255) NULL,
	[p23-2-1] [nvarchar](255) NULL,
	[RS] [float] NULL,
	[p_komissi] [nvarchar](255) NULL,
	[doljnost] [nvarchar](255) NULL,
	[Visible_TV_abit] [nvarchar](255) NULL,
	[RS_opl] [nvarchar](255) NULL,
	[o_z] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[g_s](
	[id_group] [float] NULL,
	[id_speciality] [float] NULL,
	[spec] [nvarchar](255) NULL,
	[id_faculty] [float] NULL,
	[o_z] [float] NULL,
	[id_ebe_var] [float] NULL,
	[p25-2] [nvarchar](255) NULL,
	[o_z_d] [float] NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[group](
	[id_group] [float] NULL,
	[p20] [nvarchar](255) NULL,
	[id_faculty] [float] NULL,
	[id_f_educ] [float] NULL,
	[id_login] [float] NULL,
	[p21] [float] NULL,
	[id_speciality] [float] NULL,
	[o_z] [float] NULL,
	[id_sub_group] [float] NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[kafedra](
	[id_kafedra] [float] NULL,
	[f1] [nvarchar](255) NULL,
	[sn_f1] [nvarchar](255) NULL,
	[login] [nvarchar](255) NULL,
	[pswd] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[id_kaf] [nvarchar](255) NULL,
	[id_rrnkcalc] [nvarchar](255) NULL,
	[id_faculty] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[movement_t](
	[id_protocols] [float] NULL,
	[id_group] [float] NULL,
	[id_student] [float] NULL,
	[id_rate] [float] NULL,
	[id_semester] [float] NULL,
	[id_bk] [float] NULL,
	[id_come] [float] NULL,
	[come_reg] [nvarchar](255) NULL,
	[come_date] [nvarchar](255) NULL,
	[come_k] [nvarchar](255) NULL,
	[id_speciality] [float] NULL,
	[id_leave] [float] NULL,
	[leave_reg] [float] NULL,
	[leave_date] [nvarchar](255) NULL,
	[leave_k] [nvarchar](255) NULL,
	[oper] [nvarchar](255) NULL,
	[u_date] [datetime] NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[percent_privilege] [float] NULL,
	[privilege_coment] [nvarchar](255) NULL,
	[priv_var] [nvarchar](255) NULL,
	[isStudying] [float] NULL,
	[host] [nvarchar](255) NULL,
	[F25] [nvarchar](255) NULL,
	[F26] [nvarchar](255) NULL,
	[F27] [nvarchar](255) NULL,
	[F28] [nvarchar](255) NULL,
	[F29] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Photo](
	[id_photo] [int] IDENTITY(1,1) NOT NULL,
	[photo] [nvarchar](max) NULL,
	[id_teacher] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[post](
	[id_post] [float] NULL,
	[post] [nvarchar](255) NULL,
	[p_u] [float] NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[S_G](
	[id_s_g] [float] NULL,
	[id_student] [float] NULL,
	[s_fio] [nvarchar](255) NULL,
	[id_group] [float] NULL,
	[p20] [nvarchar](255) NULL,
	[idid] [float] NULL,
	[e_mail] [nvarchar](255) NULL,
	[id_bk] [float] NULL,
	[id_semester] [float] NULL,
	[id_protocols] [float] NULL,
	[id_start_semester] [float] NULL,
	[id_speciality] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[semester](
	[id_semester] [float] NULL,
	[p43] [nvarchar](255) NULL,
	[id_rate] [float] NULL,
	[id_w_s] [float] NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[special](
	[id_special] [float] NULL,
	[id_direction] [nvarchar](255) NULL,
	[p25-1] [float] NULL,
	[p25-2] [nvarchar](255) NULL,
	[id_opl] [float] NULL,
	[standart] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[visible] [nvarchar](255) NULL,
	[p25_2k] [nvarchar](255) NULL,
	[kyrgyz_name] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Student](
	[id_student] [float] NULL,
	[nenujen] [nvarchar](255) NULL,
	[first_p1] [nvarchar](255) NULL,
	[num_date_f_p1] [nvarchar](255) NULL,
	[p1] [nvarchar](255) NULL,
	[p2] [nvarchar](255) NULL,
	[p3] [nvarchar](255) NULL,
	[BirthDate] [nvarchar](255) NULL,
	[Male] [float] NULL,
	[Lonely] [float] NULL,
	[Orphan] [nvarchar](255) NULL,
	[Invalid12Group] [nvarchar](255) NULL,
	[RegionBirth] [float] NULL,
	[DistrictBirth] [float] NULL,
	[CityBirth] [float] NULL,
	[VillageBirth] [float] NULL,
	[Streetbirth] [nvarchar](255) NULL,
	[RegionHomeAddress] [float] NULL,
	[DistrictHomeAddress] [float] NULL,
	[CityHomeAddress] [float] NULL,
	[VillageHomeAddress] [float] NULL,
	[StreetHomeAddress] [nvarchar](255) NULL,
	[adrhome] [nvarchar](255) NULL,
	[TelephoneHomeAddress] [nvarchar](255) NULL,
	[RegionNow] [float] NULL,
	[DistrictNow] [float] NULL,
	[CityNow] [float] NULL,
	[VillageNow] [float] NULL,
	[StreetNow] [nvarchar](255) NULL,
	[adrnow] [nvarchar](255) NULL,
	[TelephoneNow] [nvarchar](255) NULL,
	[SerialPas] [nvarchar](255) NULL,
	[NumberPas] [float] NULL,
	[DateGivenPas] [nvarchar](255) NULL,
	[GivenPas] [float] NULL,
	[Nationality] [float] NULL,
	[Citizenship] [float] NULL,
	[DateRegistr] [nvarchar](255) NULL,
	[FacultiesReg] [nvarchar](255) NULL,
	[Dipend] [nvarchar](255) NULL,
	[e_mail] [nvarchar](255) NULL,
	[lang] [nvarchar](255) NULL,
	[hobby] [nvarchar](255) NULL,
	[religion] [nvarchar](255) NULL,
	[visitKG] [nvarchar](255) NULL,
	[aids] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[first_Citizenship] [nvarchar](255) NULL,
	[num_date_f_Citizenship] [nvarchar](255) NULL,
	[id_a_year] [nvarchar](255) NULL,
	[id_ws] [nvarchar](255) NULL,
	[ItnGyrg] [nvarchar](255) NULL,
	[idid] [float] NULL,
	[id_republicBirth] [float] NULL,
	[id_republicHome] [float] NULL,
	[id_republicNow] [float] NULL,
	[place_work] [nvarchar](255) NULL,
	[temp] [float] NULL,
	[ZACH] [nvarchar](255) NULL,
	[inn] [nvarchar](255) NULL,
	[login] [nvarchar](255) NULL,
	[password] [nvarchar](255) NULL,
	[kol_p] [nvarchar](255) NULL,
	[endDateViza] [nvarchar](255) NULL,
	[needHome] [nvarchar](255) NULL,
	[Attribute] [nvarchar](255) NULL,
	[op] [nvarchar](255) NULL,
	[needChangePsw] [float] NULL,
	[startDateForChangePsw] [datetime] NULL,
	[host] [nvarchar](255) NULL,
	[smsAccountFromAbit] [nvarchar](255) NULL,
	[MobileLogin] [nvarchar](255) NULL,
	[MobilePassword] [nvarchar](255) NULL,
	[FlagForPassword] [float] NULL,
	[FlagForMobile] [float] NULL,
	[OldFlagForMobile] [float] NULL,
	[F78] [nvarchar](255) NULL,
	[F79] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[StudentPhoto](
	[id_photo] [float] NULL,
	[photo] [float] NULL,
	[id_student] [nvarchar](255) NULL,
	[AVN_user] [datetime] NULL,
	[AVN_update] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_fio](
	[id_teacher] [float] NULL,
	[t_fio] [nvarchar](255) NULL,
	[s_t_fio] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[teacher](
	[id_teacher] [float] NULL,
	[p26] [nvarchar](255) NULL,
	[p27] [nvarchar](255) NULL,
	[p28] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[host] [nvarchar](255) NULL,
	[status] [float] NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[V_Raspisanie_new](
	[ID] [float] NULL,
	[id_a_year] [float] NULL,
	[p32] [nvarchar](255) NULL,
	[id_w_s] [float] NULL,
	[day_number] [float] NULL,
	[Day_name] [nvarchar](255) NULL,
	[id_time] [float] NULL,
	[Time_] [nvarchar](255) NULL,
	[sort] [float] NULL,
	[vid_time] [float] NULL,
	[SubGroup] [float] NULL,
	[EveryWeek] [float] NULL,
	[ch_zham] [nvarchar](255) NULL,
	[StudyTypeID] [float] NULL,
	[StudyTypeName] [nvarchar](255) NULL,
	[id_teacher] [float] NULL,
	[s_t_fio] [nvarchar](255) NULL,
	[id_auditorium] [float] NULL,
	[number] [float] NULL,
	[id_kafedra] [float] NULL,
	[sn_f1] [nvarchar](255) NULL,
	[beg_nedeli] [float] NULL,
	[end_nedeli] [float] NULL,
	[id_group] [float] NULL,
	[p20] [nvarchar](255) NULL,
	[id_faculty] [float] NULL,
	[p23-1] [nvarchar](255) NULL,
	[p23-2] [nvarchar](255) NULL,
	[id_rate] [float] NULL,
	[p22] [nvarchar](255) NULL,
	[EmployeeID2] [float] NULL,
	[id_discipline] [float] NULL,
	[p34] [nvarchar](255) NULL,
	[Sh_Date] [nvarchar](255) NULL,
	[p34_kg] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Vakansii](
	[id_vakansiya] [float] NULL,
	[id_a_year] [float] NULL,
	[id_otdel_1] [nvarchar](255) NULL,
	[id_otdel_11] [nvarchar](255) NULL,
	[id_faculty] [float] NULL,
	[id_kafedra] [nvarchar](255) NULL,
	[id_structure] [float] NULL,
	[id_bk] [float] NULL,
	[id_post] [float] NULL,
	[q_units] [float] NULL,
	[razrad] [float] NULL,
	[Num] [float] NULL,
	[id_enter] [float] NULL,
	[e_n_p] [nvarchar](255) NULL,
	[e_d_p] [nvarchar](255) NULL,
	[id_deduce] [float] NULL,
	[d_n_p] [nvarchar](255) NULL,
	[d_d_p] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[hourFond] [nvarchar](255) NULL,
	[descr] [nvarchar](255) NULL,
	[id_o_z] [nvarchar](255) NULL,
	[id_otdel_2] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[w_s](
	[id_w_s] [float] NULL,
	[p42] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[p42_1] [nvarchar](255) NULL,
	[p42_2] [nvarchar](255) NULL,
	[ws_sort] [float] NULL,
	[opl] [float] NULL,
	[p42_KG] [nvarchar](255) NULL
) ON [PRIMARY]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Working](
	[id_working] [float] NULL,
	[id_teacher] [float] NULL,
	[id_stavka] [float] NULL,
	[id_vakansiya] [float] NULL,
	[id_base_over] [float] NULL,
	[razr] [float] NULL,
	[id_prikaz_come] [float] NULL,
	[Num_prikaz_Enter] [float] NULL,
	[date_come] [nvarchar](255) NULL,
	[from_d] [nvarchar](255) NULL,
	[temp_leave] [float] NULL,
	[id_leave] [float] NULL,
	[Num_prikaz_leave] [nvarchar](255) NULL,
	[Date_leave] [nvarchar](255) NULL,
	[Reason_quit] [nvarchar](255) NULL,
	[off_date] [nvarchar](255) NULL,
	[AVN_user] [nvarchar](255) NULL,
	[AVN_update] [nvarchar](255) NULL,
	[hourFond] [nvarchar](255) NULL,
	[id_a_year] [float] NULL
) ON [PRIMARY]
GO
