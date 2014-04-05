SET IDENTITY_INSERT [dbo].[HealthData] ON
INSERT INTO [dbo].[HealthData] ([DataId], [PatientId], [DataType], [DataValue], [DataTimeStamp]) VALUES (1, 6, N'Pulse', 60.5, NULL)
SET IDENTITY_INSERT [dbo].[HealthData] OFF
