namespace GPSUpdatus
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
            this.numUpDownBicycle = new System.Windows.Forms.NumericUpDown();
            this.label1 = new System.Windows.Forms.Label();
            this.lstRoutes = new System.Windows.Forms.ListBox();
            this.btnStartStopRoute = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.numUpDownBicycle)).BeginInit();
            this.SuspendLayout();
            // 
            // numUpDownBicycle
            // 
            this.numUpDownBicycle.Location = new System.Drawing.Point(12, 39);
            this.numUpDownBicycle.Maximum = new decimal(new int[] {
            178,
            0,
            0,
            0});
            this.numUpDownBicycle.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
            this.numUpDownBicycle.Name = "numUpDownBicycle";
            this.numUpDownBicycle.Size = new System.Drawing.Size(120, 20);
            this.numUpDownBicycle.TabIndex = 0;
            this.numUpDownBicycle.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(13, 20);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(81, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "Bicycle Number";
            // 
            // lstRoutes
            // 
            this.lstRoutes.FormattingEnabled = true;
            this.lstRoutes.Location = new System.Drawing.Point(12, 66);
            this.lstRoutes.Name = "lstRoutes";
            this.lstRoutes.Size = new System.Drawing.Size(260, 95);
            this.lstRoutes.TabIndex = 2;
            // 
            // btnStartStopRoute
            // 
            this.btnStartStopRoute.Location = new System.Drawing.Point(12, 168);
            this.btnStartStopRoute.Name = "btnStartStopRoute";
            this.btnStartStopRoute.Size = new System.Drawing.Size(120, 23);
            this.btnStartStopRoute.TabIndex = 3;
            this.btnStartStopRoute.Text = "Start/Stop Route";
            this.btnStartStopRoute.UseVisualStyleBackColor = true;
            this.btnStartStopRoute.Click += new System.EventHandler(this.btnStartStopRoute_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(284, 261);
            this.Controls.Add(this.btnStartStopRoute);
            this.Controls.Add(this.lstRoutes);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.numUpDownBicycle);
            this.Name = "Form1";
            this.Text = "Form1";
            ((System.ComponentModel.ISupportInitialize)(this.numUpDownBicycle)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.NumericUpDown numUpDownBicycle;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.ListBox lstRoutes;
        private System.Windows.Forms.Button btnStartStopRoute;
    }
}

