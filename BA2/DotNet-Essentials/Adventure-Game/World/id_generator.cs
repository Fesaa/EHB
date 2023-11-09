namespace World
{
    public class IdGenerator
    {
        private static int _id = 0;
        public static int GetId()
        {
            return DateTime.Now.Millisecond + _id++;
        }
    }
}
