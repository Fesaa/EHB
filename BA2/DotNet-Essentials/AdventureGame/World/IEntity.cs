namespace World
{
    public interface IEntity
    {
        string GetName();

        double GetHealth();

        void SetHealth(double health);

        double GetAttack();

        void SetAttack(double attack);

        bool TakeDamage(IEntity attacker);

    }
}
