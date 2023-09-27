namespace Helper;

public class Maand
{

    private static string sep = "      ";

    public int MonthNr;
    public int Year;

    public Maand(int monthNr, int year)
    {
        this.MonthNr = monthNr;
        this.Year = year;
    }

    // What in the world is this syntax LOL
    public Maand() : this(1, 1)
    { }

    private int GetDaysInFirstWeek(DateTime dt)
    {
        for (int i = 1; i < 7; i++)
        {
            if (dt.DayOfWeek == DayOfWeek.Sunday)
            {
                return i;
            }
            dt = dt.AddDays(1);
        }
        return 0;
    }

    public override string ToString()
    {
        int maxDays = DateTime.DaysInMonth(this.Year, this.MonthNr);
        DateTime dt = new DateTime(this.Year, this.MonthNr, 1, 0, 0, 0);

        int firstWeekDays = this.GetDaysInFirstWeek(dt);
        dt = dt.AddDays(-7 + firstWeekDays);

        string s = dt.ToString("MMMM") + " " + this.Year + "\n\n";
        for (int i = 0; i < 7; i++)
        {
            s += dt.ToString("ddd") + sep + sep;
            s += (dt.Month != this.MonthNr) ? "  " : dt.ToString("dd");

            int adjust = (int)dt.DayOfWeek == 0 ? 7 : (int)dt.DayOfWeek;
            for (int j = firstWeekDays + adjust; j <= maxDays; j += 7)
            {
                s += sep + j.ToString().PadLeft(2, '0');
            }
            s += "\n";
            dt = dt.AddDays(1);
        }

        return s;
    }
}
