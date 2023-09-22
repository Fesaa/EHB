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

        string sep = "      ";

        // Why does this shit HashMap have so little methods
        // computeIfAbsent????
        // getOrDefault ????
        // ANYTHING??????
        Dictionary<int, string> mapLines = new Dictionary<int, string>();
        bool passedRowOne = false;

        while (true)
        {
            int day = ((int)dt.DayOfWeek);

            // Get the line or return the start value
            string line = mapLines.ContainsKey(day) ? mapLines[day] : dt.ToString("ddd");

            // Add padding on first entry if it's in the second row
            if (dt.Day < 8 && passedRowOne)
            {
                line += sep + "  ";
            }

            line += sep + dt.ToString("dd");
            mapLines[day] = line;
            if (day == 0) // Sunday
            {
                passedRowOne = true;
            }

            // Weird ending system due to how days wrap
            if (dt.Day == maxDays)
            {
                break;
            }
            // FFS just change the object instead of returning a new one
            // or allow me to DateTime#setDay
            dt = dt.AddDays(1);
        }


        string s = dt.ToString("MMMM") + " " + this.Year + "\n\n";
        for (int i = 1; i < 8; i++)
        {
            s += mapLines[i % 7] + "\n";
        }

        return s;
    }
}
