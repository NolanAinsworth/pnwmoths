from django import template
from pnwmoths.species.models import State

register = template.Library()

def state_get_or_bc(**kwargs):
    try:
        return State.objects.get(**kwargs).code
    except Exception:
        return "CANADA"

@register.filter
def filters_json(value, arg):
    """
        Returns Array with extra values removed based on species
    """
    if arg == "county":
        return str(sorted([str("%s (%s)" % (item[0], state_get_or_bc(id=item[1]))) for item in set(value.speciesrecord_set.all().values_list(arg+'__name', 'county__state'))])).replace("'", '"')
    return str(sorted([str(item) for item in set(value.speciesrecord_set.all().values_list(arg, flat=True))])).replace("'", '"')