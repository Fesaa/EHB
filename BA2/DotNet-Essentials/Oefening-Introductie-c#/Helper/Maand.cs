namespace Helper;

public class Maand
{
    public int MonthNr;
    public int Year;

    public Maand(int monthNr, int year)
    {
        this.MonthNr = monthNr;
        this.Year = year;
    }

    // What in the world is this syntax LOL
    public Maand()
        : this(1, 1)
    { }

    // This should be able to be made more performant
    // Maybe a O(n+7) worse case instead of always
    // By getting the first sunday
    // And generating the lines directly one by one
    public override string ToString()
    {
        int maxDays = DateTime.DaysInMonth(this.Year, this.MonthNr);
        DateTime dt = new DateTime(this.Year, this.MonthNr, 1, 0, 0, 0);
        string monthName = dt.ToString("MMMM");

        string sep = "      ";

        // Get the first sunday
        DayOfWeek firstDay = dt.DayOfWeek;
        int firstWeekDays = 7;
        for (int i = 1; i < 7; i++)
        {
            if (dt.DayOfWeek == DayOfWeek.Sunday)
            {
                firstWeekDays = i;
                break;
            }
            dt = dt.AddDays(1);
        }
        // Set to monday of first week of the month
        dt = dt.AddDays(-6);

        string s = monthName + " " + this.Year + "\n\n";
        for (int i = 0; i < 7; i++)
        {
            s += dt.ToString("ddd") + sep;
            if (dt.Month != this.MonthNr)
            {
                s += sep + "  ";
            }
            else
            {
                s += sep + dt.ToString("dd");
            }
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
