namespace Helper;

public class Utils
{

    public static void Wissel(ref int a, ref int b)
    {
        int temp = a;
        a = b;
        b = temp;
    }

    public static string ToCamelCase(string s)
    {
        if (string.IsNullOrEmpty(s))
        {
            return s;
        }

        string[] parts = s.Split(" ");
        string s2 = parts[0];
        for (int i = 1; i < parts.Length; i++)
        {
            s2 += ToUpperFirstCharacter(parts[i]);
        }
        return s2;
    }

    private static string ToUpperFirstCharacter(string source)
    {
        if (string.IsNullOrEmpty(source))
        {
            return source;
        }
        char[] chars = source.ToCharArray();
        chars[0] = char.ToUpper(chars[0]);
        return new string(chars);
    }


}
