; Script generated by the Inno Setup Script Wizard.
; SEE THE DOCUMENTATION FOR DETAILS ON CREATING INNO SETUP SCRIPT FILES!

#define MyAppName "LeSa"
#define MyAppVersion "1.5"
#define MyAppPublisher "odb, Inc."
#define MyAppURL "https://www.odero.com/"

[Setup]
; NOTE: The value of AppId uniquely identifies this application. Do not use the same AppId value in installers for other applications.
; (To generate a new GUID, click Tools | Generate GUID inside the IDE.)
AppId={{95E63D9E-080C-46CB-9D68-4A1CCA04BCD6}
AppName={#MyAppName}
AppVersion={#MyAppVersion}
;AppVerName={#MyAppName} {#MyAppVersion}
AppPublisher={#MyAppPublisher}
AppPublisherURL={#MyAppURL}
AppSupportURL={#MyAppURL}
AppUpdatesURL={#MyAppURL}
DefaultDirName={autopf}\{#MyAppName}
DefaultGroupName={#MyAppName}
; Uncomment the following line to run in non administrative install mode (install for current user only.)
;PrivilegesRequired=lowest
OutputBaseFilename=mysetup
Compression=lzma
SolidCompression=yes
WizardStyle=modern

[Languages]
Name: "english"; MessagesFile: "compiler:Default.isl"

[Files]
Source: "C:\wamp64\www\popo\account_request.html"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\add_subject.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\add_user.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\add_user_step1.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\add_user_step2.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\add_user_step3.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\allocate_lessons.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\allocate_subjects.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\approve_request.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\authenticate.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\auto_reject_requests.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\change_password.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\change_password_2.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\change-password.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\check_otp.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\composer.json"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\composer.lock"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\config.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\dashboard_admin.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\dashboard_cRep.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\dashboard_hod.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\dashboard_lecturer.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\default.jpg"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\font.txt"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\generate_timetables.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\Gruntfile.js"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\handle_request.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\header.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\index.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\login.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\logout.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\manual_amendment.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\mark_notification_as_read.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\notification-icon.png"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\notifications.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\nysei_lesa.sql"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\nysei_lesa_2.sql"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\nyslogo.png"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\process_amendment.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\process_request.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\profile.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\read_messages.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\reject_request.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\reset_password.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\save_user.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\script.js"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\send_mail.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\send_message.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\send_otp.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\settings.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\sidebar.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\styles.css"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\timetable.html"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\update_password.php"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\wamp64\www\popo\verify_otp.php"; DestDir: "{app}"; Flags: ignoreversion
; NOTE: Don't use "Flags: ignoreversion" on any shared system files

[Icons]
Name: "{group}\{cm:ProgramOnTheWeb,{#MyAppName}}"; Filename: "{#MyAppURL}"
Name: "{group}\{cm:UninstallProgram,{#MyAppName}}"; Filename: "{uninstallexe}"

