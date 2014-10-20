using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace BicycleStation
{
    public partial class Form1 : Form
    {
        const int MAXTIME = 120;
        int _maxTime = MAXTIME;

        public Form1()
        {
            InitializeComponent();
            //StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
        }

        private void lockTimer_Tick(object sender, EventArgs e)
        {
            if (_maxTime == 0)
            {
                lockTimer.Stop();
                _maxTime = MAXTIME;
            }
            else
            {
                _maxTime--;
                TimeSpan timespan = TimeSpan.FromSeconds(_maxTime);
                TimeLbl.Text = timespan.ToString(@"mm\:ss");
            }
        }

        private void StationNameDropDown_SelectedIndexChanged(object sender, EventArgs e)
        {
            /* Load en farlig masse */
        }

        private void passwordTB_Click(object sender, EventArgs e)
        {
            if (passwordTB.Text == "Key")
            {
                passwordTB.Clear();
            }
        }

        private void UnlockBtn_Click(object sender, EventArgs e)
        {
            int pwText = 0;
            DatabaseConnection DB = new DatabaseConnection();
            try
            {
                pwText = Convert.ToInt32(passwordTB.Text.ToString());
                if (DB.booking.Select(x => x.Password == pwText).Count() > 0)
                {
                    // Do validation of password
                    EnterPwPanel.Visible = false;
                    EnterPwPanel.SendToBack();

                    TakeItPanel.BringToFront();
                    TakeItPanel.Visible = true;

                    lockTimer.Start();
                }
                else
                {
                    MessageBox.Show("Incorrect Key");
                }
            }
            catch (FormatException){
                MessageBox.Show("Incorrect Key");
            }


        }

        private void UnlockMoreBtn_Click(object sender, EventArgs e)
        {
            lockTimer.Stop();
            _maxTime = MAXTIME;
            TimeLbl.Text = "";
            TakeItPanel.Visible = false;
            TakeItPanel.SendToBack();

            passwordTB.Text = "Key";
            EnterPwPanel.BringToFront();
            EnterPwPanel.Visible = true;
        }

    }
}
