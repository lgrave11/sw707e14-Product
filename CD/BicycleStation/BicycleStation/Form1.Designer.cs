namespace BicycleStation
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            this.splitContainer1 = new System.Windows.Forms.SplitContainer();
            this.EnterPwPanel = new System.Windows.Forms.Panel();
            this.UnlockedNumberLbl = new System.Windows.Forms.Label();
            this.LockednumberLbl = new System.Windows.Forms.Label();
            this.UnlockedLbl = new System.Windows.Forms.Label();
            this.LockedLbl = new System.Windows.Forms.Label();
            this.pwPan = new System.Windows.Forms.Panel();
            this.UnlockBtn = new System.Windows.Forms.Button();
            this.KeyLbl = new System.Windows.Forms.Label();
            this.passwordTB = new System.Windows.Forms.TextBox();
            this.IncorrectPWpan = new System.Windows.Forms.Panel();
            this.incorrectPwLbl2 = new System.Windows.Forms.Label();
            this.IncorrectPWreturnBtn = new System.Windows.Forms.Button();
            this.IncorrectPWinput = new System.Windows.Forms.TextBox();
            this.IncorrectPWbtn = new System.Windows.Forms.Button();
            this.IncorrectPWlabel = new System.Windows.Forms.Label();
            this.TakeItPanel = new System.Windows.Forms.Panel();
            this.TimeLbl = new System.Windows.Forms.Label();
            this.UnlockMoreBtn = new System.Windows.Forms.Button();
            this.TakeAtDockLbl = new System.Windows.Forms.Label();
            this.btnRemove = new System.Windows.Forms.Button();
            this.btnAdd = new System.Windows.Forms.Button();
            this.returnIDlbl = new System.Windows.Forms.Label();
            this.idTB = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.ReturnBicycleBtn = new System.Windows.Forms.Button();
            this.TakeBicycleBtn = new System.Windows.Forms.Button();
            this.NoBicycleStateLbl = new System.Windows.Forms.Label();
            this.UnlockStateLbl = new System.Windows.Forms.Label();
            this.LockStateLbl = new System.Windows.Forms.Label();
            this.DockStateLbl = new System.Windows.Forms.Label();
            this.DockStateBar = new System.Windows.Forms.TrackBar();
            this.DockNumberLbl = new System.Windows.Forms.Label();
            this.StationLbl = new System.Windows.Forms.Label();
            this.DockIdUpDown = new System.Windows.Forms.NumericUpDown();
            this.StationNameDropDown = new System.Windows.Forms.ComboBox();
            this.lockTimer = new System.Windows.Forms.Timer(this.components);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainer1)).BeginInit();
            this.splitContainer1.Panel1.SuspendLayout();
            this.splitContainer1.Panel2.SuspendLayout();
            this.splitContainer1.SuspendLayout();
            this.EnterPwPanel.SuspendLayout();
            this.pwPan.SuspendLayout();
            this.IncorrectPWpan.SuspendLayout();
            this.TakeItPanel.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.DockStateBar)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.DockIdUpDown)).BeginInit();
            this.SuspendLayout();
            // 
            // splitContainer1
            // 
            this.splitContainer1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainer1.FixedPanel = System.Windows.Forms.FixedPanel.Panel1;
            this.splitContainer1.IsSplitterFixed = true;
            this.splitContainer1.Location = new System.Drawing.Point(0, 0);
            this.splitContainer1.Name = "splitContainer1";
            // 
            // splitContainer1.Panel1
            // 
            this.splitContainer1.Panel1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(49)))), ((int)(((byte)(95)))));
            this.splitContainer1.Panel1.Controls.Add(this.EnterPwPanel);
            this.splitContainer1.Panel1.Controls.Add(this.TakeItPanel);
            this.splitContainer1.Panel1.RightToLeft = System.Windows.Forms.RightToLeft.No;
            // 
            // splitContainer1.Panel2
            // 
            this.splitContainer1.Panel2.Controls.Add(this.btnRemove);
            this.splitContainer1.Panel2.Controls.Add(this.btnAdd);
            this.splitContainer1.Panel2.Controls.Add(this.returnIDlbl);
            this.splitContainer1.Panel2.Controls.Add(this.idTB);
            this.splitContainer1.Panel2.Controls.Add(this.label1);
            this.splitContainer1.Panel2.Controls.Add(this.ReturnBicycleBtn);
            this.splitContainer1.Panel2.Controls.Add(this.TakeBicycleBtn);
            this.splitContainer1.Panel2.Controls.Add(this.NoBicycleStateLbl);
            this.splitContainer1.Panel2.Controls.Add(this.UnlockStateLbl);
            this.splitContainer1.Panel2.Controls.Add(this.LockStateLbl);
            this.splitContainer1.Panel2.Controls.Add(this.DockStateLbl);
            this.splitContainer1.Panel2.Controls.Add(this.DockStateBar);
            this.splitContainer1.Panel2.Controls.Add(this.DockNumberLbl);
            this.splitContainer1.Panel2.Controls.Add(this.StationLbl);
            this.splitContainer1.Panel2.Controls.Add(this.DockIdUpDown);
            this.splitContainer1.Panel2.Controls.Add(this.StationNameDropDown);
            this.splitContainer1.Panel2.RightToLeft = System.Windows.Forms.RightToLeft.No;
            this.splitContainer1.Size = new System.Drawing.Size(861, 534);
            this.splitContainer1.SplitterDistance = 607;
            this.splitContainer1.TabIndex = 0;
            // 
            // EnterPwPanel
            // 
            this.EnterPwPanel.Controls.Add(this.UnlockedNumberLbl);
            this.EnterPwPanel.Controls.Add(this.LockednumberLbl);
            this.EnterPwPanel.Controls.Add(this.UnlockedLbl);
            this.EnterPwPanel.Controls.Add(this.LockedLbl);
            this.EnterPwPanel.Controls.Add(this.pwPan);
            this.EnterPwPanel.Controls.Add(this.IncorrectPWpan);
            this.EnterPwPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.EnterPwPanel.Location = new System.Drawing.Point(0, 0);
            this.EnterPwPanel.Margin = new System.Windows.Forms.Padding(0);
            this.EnterPwPanel.Name = "EnterPwPanel";
            this.EnterPwPanel.Size = new System.Drawing.Size(607, 534);
            this.EnterPwPanel.TabIndex = 11;
            // 
            // UnlockedNumberLbl
            // 
            this.UnlockedNumberLbl.AutoSize = true;
            this.UnlockedNumberLbl.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(49)))), ((int)(((byte)(95)))));
            this.UnlockedNumberLbl.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.UnlockedNumberLbl.ForeColor = System.Drawing.Color.White;
            this.UnlockedNumberLbl.Location = new System.Drawing.Point(440, 112);
            this.UnlockedNumberLbl.Name = "UnlockedNumberLbl";
            this.UnlockedNumberLbl.Size = new System.Drawing.Size(36, 40);
            this.UnlockedNumberLbl.TabIndex = 11;
            this.UnlockedNumberLbl.Text = "7";
            // 
            // LockednumberLbl
            // 
            this.LockednumberLbl.AutoSize = true;
            this.LockednumberLbl.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.LockednumberLbl.ForeColor = System.Drawing.Color.White;
            this.LockednumberLbl.Location = new System.Drawing.Point(124, 112);
            this.LockednumberLbl.Name = "LockednumberLbl";
            this.LockednumberLbl.Size = new System.Drawing.Size(36, 40);
            this.LockednumberLbl.TabIndex = 10;
            this.LockednumberLbl.Text = "3";
            // 
            // UnlockedLbl
            // 
            this.UnlockedLbl.AutoSize = true;
            this.UnlockedLbl.Font = new System.Drawing.Font("Arial", 20.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.UnlockedLbl.ForeColor = System.Drawing.Color.White;
            this.UnlockedLbl.Location = new System.Drawing.Point(370, 78);
            this.UnlockedLbl.Name = "UnlockedLbl";
            this.UnlockedLbl.Size = new System.Drawing.Size(162, 32);
            this.UnlockedLbl.TabIndex = 9;
            this.UnlockedLbl.Text = "Free to take";
            // 
            // LockedLbl
            // 
            this.LockedLbl.AutoSize = true;
            this.LockedLbl.Font = new System.Drawing.Font("Arial", 20.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.LockedLbl.ForeColor = System.Drawing.Color.White;
            this.LockedLbl.Location = new System.Drawing.Point(47, 78);
            this.LockedLbl.Name = "LockedLbl";
            this.LockedLbl.Size = new System.Drawing.Size(209, 32);
            this.LockedLbl.TabIndex = 8;
            this.LockedLbl.Text = "Locked bicycles";
            // 
            // pwPan
            // 
            this.pwPan.Controls.Add(this.UnlockBtn);
            this.pwPan.Controls.Add(this.KeyLbl);
            this.pwPan.Controls.Add(this.passwordTB);
            this.pwPan.Location = new System.Drawing.Point(53, 219);
            this.pwPan.Name = "pwPan";
            this.pwPan.Size = new System.Drawing.Size(495, 273);
            this.pwPan.TabIndex = 15;
            // 
            // UnlockBtn
            // 
            this.UnlockBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(64)))), ((int)(((byte)(124)))));
            this.UnlockBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.UnlockBtn.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.UnlockBtn.ForeColor = System.Drawing.Color.White;
            this.UnlockBtn.Location = new System.Drawing.Point(160, 180);
            this.UnlockBtn.Name = "UnlockBtn";
            this.UnlockBtn.Size = new System.Drawing.Size(184, 66);
            this.UnlockBtn.TabIndex = 13;
            this.UnlockBtn.Text = "Unlock";
            this.UnlockBtn.UseVisualStyleBackColor = false;
            this.UnlockBtn.Click += new System.EventHandler(this.UnlockBtn_Click);
            // 
            // KeyLbl
            // 
            this.KeyLbl.AutoSize = true;
            this.KeyLbl.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.KeyLbl.ForeColor = System.Drawing.Color.White;
            this.KeyLbl.Location = new System.Drawing.Point(125, 27);
            this.KeyLbl.Name = "KeyLbl";
            this.KeyLbl.Size = new System.Drawing.Size(256, 40);
            this.KeyLbl.TabIndex = 12;
            this.KeyLbl.Text = "Enter password";
            // 
            // passwordTB
            // 
            this.passwordTB.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(64)))), ((int)(((byte)(124)))));
            this.passwordTB.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.passwordTB.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.passwordTB.ForeColor = System.Drawing.Color.White;
            this.passwordTB.Location = new System.Drawing.Point(160, 103);
            this.passwordTB.MaxLength = 6;
            this.passwordTB.Name = "passwordTB";
            this.passwordTB.Size = new System.Drawing.Size(184, 48);
            this.passwordTB.TabIndex = 7;
            this.passwordTB.Text = "Password";
            this.passwordTB.Click += new System.EventHandler(this.passwordTB_Click);
            // 
            // IncorrectPWpan
            // 
            this.IncorrectPWpan.Controls.Add(this.incorrectPwLbl2);
            this.IncorrectPWpan.Controls.Add(this.IncorrectPWreturnBtn);
            this.IncorrectPWpan.Controls.Add(this.IncorrectPWinput);
            this.IncorrectPWpan.Controls.Add(this.IncorrectPWbtn);
            this.IncorrectPWpan.Controls.Add(this.IncorrectPWlabel);
            this.IncorrectPWpan.ForeColor = System.Drawing.SystemColors.Control;
            this.IncorrectPWpan.Location = new System.Drawing.Point(53, 219);
            this.IncorrectPWpan.Name = "IncorrectPWpan";
            this.IncorrectPWpan.Size = new System.Drawing.Size(495, 273);
            this.IncorrectPWpan.TabIndex = 14;
            // 
            // incorrectPwLbl2
            // 
            this.incorrectPwLbl2.AutoSize = true;
            this.incorrectPwLbl2.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.incorrectPwLbl2.Location = new System.Drawing.Point(174, 57);
            this.incorrectPwLbl2.Name = "incorrectPwLbl2";
            this.incorrectPwLbl2.Size = new System.Drawing.Size(142, 24);
            this.incorrectPwLbl2.TabIndex = 4;
            this.incorrectPwLbl2.Text = "Please try again";
            // 
            // IncorrectPWreturnBtn
            // 
            this.IncorrectPWreturnBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.IncorrectPWreturnBtn.Font = new System.Drawing.Font("Microsoft Sans Serif", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.IncorrectPWreturnBtn.Location = new System.Drawing.Point(340, 192);
            this.IncorrectPWreturnBtn.Name = "IncorrectPWreturnBtn";
            this.IncorrectPWreturnBtn.Size = new System.Drawing.Size(123, 54);
            this.IncorrectPWreturnBtn.TabIndex = 3;
            this.IncorrectPWreturnBtn.Text = "Return";
            this.IncorrectPWreturnBtn.UseVisualStyleBackColor = true;
            this.IncorrectPWreturnBtn.Click += new System.EventHandler(this.IncorrectPWreturnBtn_Click);
            // 
            // IncorrectPWinput
            // 
            this.IncorrectPWinput.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(64)))), ((int)(((byte)(124)))));
            this.IncorrectPWinput.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.IncorrectPWinput.Font = new System.Drawing.Font("Microsoft Sans Serif", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.IncorrectPWinput.ForeColor = System.Drawing.SystemColors.Control;
            this.IncorrectPWinput.Location = new System.Drawing.Point(145, 106);
            this.IncorrectPWinput.MaxLength = 6;
            this.IncorrectPWinput.Name = "IncorrectPWinput";
            this.IncorrectPWinput.Size = new System.Drawing.Size(193, 47);
            this.IncorrectPWinput.TabIndex = 2;
            this.IncorrectPWinput.Text = "Password";
            this.IncorrectPWinput.TextChanged += new System.EventHandler(this.IncorrectPWinput_TextChanged);
            // 
            // IncorrectPWbtn
            // 
            this.IncorrectPWbtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.IncorrectPWbtn.Font = new System.Drawing.Font("Microsoft Sans Serif", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.IncorrectPWbtn.ForeColor = System.Drawing.SystemColors.Control;
            this.IncorrectPWbtn.Location = new System.Drawing.Point(26, 192);
            this.IncorrectPWbtn.Name = "IncorrectPWbtn";
            this.IncorrectPWbtn.Size = new System.Drawing.Size(293, 54);
            this.IncorrectPWbtn.TabIndex = 1;
            this.IncorrectPWbtn.Text = "Try Again";
            this.IncorrectPWbtn.UseVisualStyleBackColor = true;
            this.IncorrectPWbtn.Click += new System.EventHandler(this.IncorrectPWbtn_Click);
            // 
            // IncorrectPWlabel
            // 
            this.IncorrectPWlabel.AutoSize = true;
            this.IncorrectPWlabel.Font = new System.Drawing.Font("Microsoft Sans Serif", 27.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.IncorrectPWlabel.ForeColor = System.Drawing.SystemColors.Control;
            this.IncorrectPWlabel.Location = new System.Drawing.Point(110, 14);
            this.IncorrectPWlabel.Name = "IncorrectPWlabel";
            this.IncorrectPWlabel.Size = new System.Drawing.Size(337, 42);
            this.IncorrectPWlabel.TabIndex = 0;
            this.IncorrectPWlabel.Text = "Incorrect Password";
            // 
            // TakeItPanel
            // 
            this.TakeItPanel.Controls.Add(this.TimeLbl);
            this.TakeItPanel.Controls.Add(this.UnlockMoreBtn);
            this.TakeItPanel.Controls.Add(this.TakeAtDockLbl);
            this.TakeItPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.TakeItPanel.Location = new System.Drawing.Point(0, 0);
            this.TakeItPanel.Name = "TakeItPanel";
            this.TakeItPanel.Size = new System.Drawing.Size(607, 534);
            this.TakeItPanel.TabIndex = 7;
            // 
            // TimeLbl
            // 
            this.TimeLbl.AutoSize = true;
            this.TimeLbl.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.TimeLbl.ForeColor = System.Drawing.Color.White;
            this.TimeLbl.Location = new System.Drawing.Point(257, 215);
            this.TimeLbl.Name = "TimeLbl";
            this.TimeLbl.Size = new System.Drawing.Size(103, 40);
            this.TimeLbl.TabIndex = 10;
            this.TimeLbl.Text = "01:59";
            this.TimeLbl.Visible = false;
            // 
            // UnlockMoreBtn
            // 
            this.UnlockMoreBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(0)))), ((int)(((byte)(64)))), ((int)(((byte)(124)))));
            this.UnlockMoreBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.UnlockMoreBtn.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.UnlockMoreBtn.ForeColor = System.Drawing.Color.White;
            this.UnlockMoreBtn.Location = new System.Drawing.Point(171, 279);
            this.UnlockMoreBtn.Name = "UnlockMoreBtn";
            this.UnlockMoreBtn.Size = new System.Drawing.Size(254, 66);
            this.UnlockMoreBtn.TabIndex = 9;
            this.UnlockMoreBtn.Text = "Unlock more";
            this.UnlockMoreBtn.UseVisualStyleBackColor = false;
            this.UnlockMoreBtn.Click += new System.EventHandler(this.UnlockMoreBtn_Click);
            // 
            // TakeAtDockLbl
            // 
            this.TakeAtDockLbl.AutoSize = true;
            this.TakeAtDockLbl.Font = new System.Drawing.Font("Arial", 26.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.TakeAtDockLbl.ForeColor = System.Drawing.Color.White;
            this.TakeAtDockLbl.Location = new System.Drawing.Point(59, 137);
            this.TakeAtDockLbl.Name = "TakeAtDockLbl";
            this.TakeAtDockLbl.Size = new System.Drawing.Size(447, 40);
            this.TakeAtDockLbl.TabIndex = 8;
            this.TakeAtDockLbl.Text = "Take your bicycle at dock 10";
            // 
            // btnRemove
            // 
            this.btnRemove.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnRemove.Location = new System.Drawing.Point(133, 477);
            this.btnRemove.Name = "btnRemove";
            this.btnRemove.Size = new System.Drawing.Size(94, 45);
            this.btnRemove.TabIndex = 15;
            this.btnRemove.Text = "Remove";
            this.btnRemove.UseVisualStyleBackColor = true;
            this.btnRemove.Click += new System.EventHandler(this.btnRemove_Click);
            // 
            // btnAdd
            // 
            this.btnAdd.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.btnAdd.Location = new System.Drawing.Point(17, 477);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.Size = new System.Drawing.Size(94, 45);
            this.btnAdd.TabIndex = 14;
            this.btnAdd.Text = "Add";
            this.btnAdd.UseVisualStyleBackColor = true;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // returnIDlbl
            // 
            this.returnIDlbl.AutoSize = true;
            this.returnIDlbl.Location = new System.Drawing.Point(152, 421);
            this.returnIDlbl.Name = "returnIDlbl";
            this.returnIDlbl.Size = new System.Drawing.Size(16, 13);
            this.returnIDlbl.TabIndex = 13;
            this.returnIDlbl.Text = "Id";
            // 
            // idTB
            // 
            this.idTB.Location = new System.Drawing.Point(183, 418);
            this.idTB.Name = "idTB";
            this.idTB.Size = new System.Drawing.Size(44, 20);
            this.idTB.TabIndex = 12;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.label1.Location = new System.Drawing.Point(37, 325);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(164, 24);
            this.label1.TabIndex = 11;
            this.label1.Text = "Dock State Control";
            // 
            // ReturnBicycleBtn
            // 
            this.ReturnBicycleBtn.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.ReturnBicycleBtn.Location = new System.Drawing.Point(138, 360);
            this.ReturnBicycleBtn.Name = "ReturnBicycleBtn";
            this.ReturnBicycleBtn.Size = new System.Drawing.Size(89, 45);
            this.ReturnBicycleBtn.TabIndex = 10;
            this.ReturnBicycleBtn.Text = "Return";
            this.ReturnBicycleBtn.UseVisualStyleBackColor = true;
            this.ReturnBicycleBtn.Click += new System.EventHandler(this.ReturnBicycleBtn_Click);
            // 
            // TakeBicycleBtn
            // 
            this.TakeBicycleBtn.Font = new System.Drawing.Font("Microsoft Sans Serif", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.TakeBicycleBtn.Location = new System.Drawing.Point(17, 360);
            this.TakeBicycleBtn.Name = "TakeBicycleBtn";
            this.TakeBicycleBtn.Size = new System.Drawing.Size(94, 45);
            this.TakeBicycleBtn.TabIndex = 9;
            this.TakeBicycleBtn.Text = "Take";
            this.TakeBicycleBtn.UseVisualStyleBackColor = true;
            this.TakeBicycleBtn.Click += new System.EventHandler(this.TakeBicycleBtn_Click);
            // 
            // NoBicycleStateLbl
            // 
            this.NoBicycleStateLbl.AutoSize = true;
            this.NoBicycleStateLbl.Location = new System.Drawing.Point(180, 219);
            this.NoBicycleStateLbl.Name = "NoBicycleStateLbl";
            this.NoBicycleStateLbl.Size = new System.Drawing.Size(58, 13);
            this.NoBicycleStateLbl.TabIndex = 8;
            this.NoBicycleStateLbl.Text = "No Bicycle";
            // 
            // UnlockStateLbl
            // 
            this.UnlockStateLbl.AutoSize = true;
            this.UnlockStateLbl.Location = new System.Drawing.Point(100, 219);
            this.UnlockStateLbl.Name = "UnlockStateLbl";
            this.UnlockStateLbl.Size = new System.Drawing.Size(53, 13);
            this.UnlockStateLbl.TabIndex = 7;
            this.UnlockStateLbl.Text = "Unlocked";
            // 
            // LockStateLbl
            // 
            this.LockStateLbl.AutoSize = true;
            this.LockStateLbl.Location = new System.Drawing.Point(14, 219);
            this.LockStateLbl.Name = "LockStateLbl";
            this.LockStateLbl.Size = new System.Drawing.Size(43, 13);
            this.LockStateLbl.TabIndex = 6;
            this.LockStateLbl.Text = "Locked";
            // 
            // DockStateLbl
            // 
            this.DockStateLbl.AutoSize = true;
            this.DockStateLbl.Font = new System.Drawing.Font("Arial", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.DockStateLbl.Location = new System.Drawing.Point(14, 144);
            this.DockStateLbl.Name = "DockStateLbl";
            this.DockStateLbl.Size = new System.Drawing.Size(86, 18);
            this.DockStateLbl.TabIndex = 5;
            this.DockStateLbl.Text = "Dock State";
            // 
            // DockStateBar
            // 
            this.DockStateBar.Enabled = false;
            this.DockStateBar.LargeChange = 1;
            this.DockStateBar.Location = new System.Drawing.Point(17, 174);
            this.DockStateBar.Maximum = 2;
            this.DockStateBar.Name = "DockStateBar";
            this.DockStateBar.Size = new System.Drawing.Size(220, 45);
            this.DockStateBar.TabIndex = 4;
            // 
            // DockNumberLbl
            // 
            this.DockNumberLbl.AutoSize = true;
            this.DockNumberLbl.Font = new System.Drawing.Font("Arial", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.DockNumberLbl.Location = new System.Drawing.Point(14, 77);
            this.DockNumberLbl.Name = "DockNumberLbl";
            this.DockNumberLbl.Size = new System.Drawing.Size(73, 18);
            this.DockNumberLbl.TabIndex = 3;
            this.DockNumberLbl.Text = "Dock No.";
            // 
            // StationLbl
            // 
            this.StationLbl.AutoSize = true;
            this.StationLbl.Font = new System.Drawing.Font("Arial", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
            this.StationLbl.Location = new System.Drawing.Point(14, 37);
            this.StationLbl.Name = "StationLbl";
            this.StationLbl.Size = new System.Drawing.Size(57, 18);
            this.StationLbl.TabIndex = 2;
            this.StationLbl.Text = "Station";
            // 
            // DockIdUpDown
            // 
            this.DockIdUpDown.Location = new System.Drawing.Point(117, 77);
            this.DockIdUpDown.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
            this.DockIdUpDown.Name = "DockIdUpDown";
            this.DockIdUpDown.Size = new System.Drawing.Size(120, 20);
            this.DockIdUpDown.TabIndex = 1;
            this.DockIdUpDown.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
            this.DockIdUpDown.ValueChanged += new System.EventHandler(this.DockIdUpDown_ValueChanged);
            // 
            // StationNameDropDown
            // 
            this.StationNameDropDown.FormattingEnabled = true;
            this.StationNameDropDown.Location = new System.Drawing.Point(117, 37);
            this.StationNameDropDown.Name = "StationNameDropDown";
            this.StationNameDropDown.Size = new System.Drawing.Size(121, 21);
            this.StationNameDropDown.TabIndex = 0;
            this.StationNameDropDown.SelectedIndexChanged += new System.EventHandler(this.StationNameDropDown_SelectedIndexChanged);
            // 
            // lockTimer
            // 
            this.lockTimer.Interval = 1000;
            this.lockTimer.Tick += new System.EventHandler(this.lockTimer_Tick);
            // 
            // Form1
            // 
            this.AcceptButton = this.UnlockBtn;
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(861, 534);
            this.Controls.Add(this.splitContainer1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle;
            this.MaximizeBox = false;
            this.Name = "Form1";
            this.RightToLeft = System.Windows.Forms.RightToLeft.No;
            this.Text = "Station";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.Form1_FormClosing);
            this.Shown += new System.EventHandler(this.Form1_Shown);
            this.splitContainer1.Panel1.ResumeLayout(false);
            this.splitContainer1.Panel2.ResumeLayout(false);
            this.splitContainer1.Panel2.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainer1)).EndInit();
            this.splitContainer1.ResumeLayout(false);
            this.EnterPwPanel.ResumeLayout(false);
            this.EnterPwPanel.PerformLayout();
            this.pwPan.ResumeLayout(false);
            this.pwPan.PerformLayout();
            this.IncorrectPWpan.ResumeLayout(false);
            this.IncorrectPWpan.PerformLayout();
            this.TakeItPanel.ResumeLayout(false);
            this.TakeItPanel.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.DockStateBar)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.DockIdUpDown)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.SplitContainer splitContainer1;
        private System.Windows.Forms.TrackBar DockStateBar;
        private System.Windows.Forms.Label DockNumberLbl;
        private System.Windows.Forms.Label StationLbl;
        private System.Windows.Forms.NumericUpDown DockIdUpDown;
        private System.Windows.Forms.ComboBox StationNameDropDown;
        private System.Windows.Forms.Label NoBicycleStateLbl;
        private System.Windows.Forms.Label UnlockStateLbl;
        private System.Windows.Forms.Label LockStateLbl;
        private System.Windows.Forms.Label DockStateLbl;
        private System.Windows.Forms.Panel TakeItPanel;
        private System.Windows.Forms.Button UnlockMoreBtn;
        private System.Windows.Forms.Label TakeAtDockLbl;
        private System.Windows.Forms.Label TimeLbl;
        private System.Windows.Forms.Timer lockTimer;
        private System.Windows.Forms.Panel EnterPwPanel;
        private System.Windows.Forms.Button UnlockBtn;
        private System.Windows.Forms.Label KeyLbl;
        private System.Windows.Forms.Label UnlockedNumberLbl;
        private System.Windows.Forms.Label LockednumberLbl;
        private System.Windows.Forms.Label UnlockedLbl;
        private System.Windows.Forms.Label LockedLbl;
        private System.Windows.Forms.TextBox passwordTB;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button ReturnBicycleBtn;
        private System.Windows.Forms.Button TakeBicycleBtn;
        private System.Windows.Forms.Label returnIDlbl;
        private System.Windows.Forms.TextBox idTB;
        private System.Windows.Forms.Button btnRemove;
        private System.Windows.Forms.Button btnAdd;
        private System.Windows.Forms.Panel IncorrectPWpan;
        private System.Windows.Forms.Button IncorrectPWreturnBtn;
        private System.Windows.Forms.TextBox IncorrectPWinput;
        private System.Windows.Forms.Button IncorrectPWbtn;
        private System.Windows.Forms.Label IncorrectPWlabel;
        private System.Windows.Forms.Panel pwPan;
        private System.Windows.Forms.Label incorrectPwLbl2;

    }
}

